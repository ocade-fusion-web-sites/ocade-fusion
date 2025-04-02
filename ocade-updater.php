<?php

namespace OcadeChildMinimal;

defined('ABSPATH') || exit;

// Exécuter uniquement dans l’admin sur la page de mise à jour des plugins
if (is_admin() && isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], 'update-core.php') !== false) {

    // Définition des variables globales
    $ORGANISATION_GITHUB = 'ocade-fusion-web-sites';
    $DEPOT_GITHUB = 'no-code-tools';

    $OCADE_THEME_REPO = 'https://github.com/' . $ORGANISATION_GITHUB . '/' . $DEPOT_GITHUB;
    $OCADE_GITHUB_API_URL = "https://api.github.com/repos/$ORGANISATION_GITHUB/$DEPOT_GITHUB/releases/latest";
    $OCADE_ZIP_URL = $OCADE_THEME_REPO . '/releases/latest/download/' . $DEPOT_GITHUB . '.zip';
    $OCADE_REMOTE_VERSION = $DEPOT_GITHUB . '_remote_version';
    $OCADE_ICONS = [
        'svg' => 'https://raw.githubusercontent.com/' . $ORGANISATION_GITHUB . '/' . $DEPOT_GITHUB . '/master/assets/icons/icon.svg',
        '1x' => 'https://raw.githubusercontent.com/' . $ORGANISATION_GITHUB . '/' . $DEPOT_GITHUB . '/master/assets/icons/icon-1x.png',
        '2x' => 'https://raw.githubusercontent.com/' . $ORGANISATION_GITHUB . '/' . $DEPOT_GITHUB . '/master/assets/icons/icon-2x.png',
        '3x' => 'https://raw.githubusercontent.com/' . $ORGANISATION_GITHUB . '/' . $DEPOT_GITHUB . '/master/assets/icons/icon-3x.png',
        '4x' => 'https://raw.githubusercontent.com/' . $ORGANISATION_GITHUB . '/' . $DEPOT_GITHUB . '/master/assets/icons/icon-4x.png',
        '5x' => 'https://raw.githubusercontent.com/' . $ORGANISATION_GITHUB . '/' . $DEPOT_GITHUB . '/master/assets/icons/icon-5x.png'
    ];

    add_filter('site_transient_update_themes', function ($transient) use ($OCADE_THEME_REPO, $OCADE_GITHUB_API_URL, $OCADE_ZIP_URL, $OCADE_REMOTE_VERSION, $OCADE_ICONS) {
        if (!is_object($transient)) $transient = new \stdClass();

        $theme = wp_get_theme();
        $theme_slug = $theme->get_stylesheet();
        $current_version = $theme->get('Version');

        // Récupérer la version distante
        $remote_version = get_transient($OCADE_REMOTE_VERSION);
        if (!$remote_version) {

            // Récupérer la dernière release depuis l'API GitHub
            $response = wp_remote_get($OCADE_GITHUB_API_URL, [
                'headers' => [
                    'User-Agent' => 'WordPress' // GitHub requiert un User-Agent personnalisé
                ]
            ]);

            if (is_wp_error($response)) {
                error_log('Erreur lors de la récupération de la release GitHub : ' . $response->get_error_message());
                return $transient;
            }

            $body = json_decode(wp_remote_retrieve_body($response), true);

            if (!empty($body['assets'])) {
                foreach ($body['assets'] as $asset) {
                    if ($asset['name'] === 'version.txt') {
                        $version_file_url = $asset['browser_download_url'];
                        break;
                    }
                }
            } else {
                var_dump($body['message']);
            }

            if (!empty($version_file_url)) {
                $version_response = wp_remote_get($version_file_url);

                if (!is_wp_error($version_response)) {
                    $remote_version = trim(wp_remote_retrieve_body($version_response));
                    $remote_version = preg_replace('/[^0-9.]/', '', $remote_version);

                    if (!empty($remote_version)) {
                        set_transient($OCADE_REMOTE_VERSION, $remote_version, 6 * HOUR_IN_SECONDS);
                    } else {
                        error_log('La version récupérée depuis les assets est vide.');
                    }
                }
            } else {
                error_log('Aucun fichier version.txt trouvé dans les assets de la dernière release.');
            }
        }

        // Comparaison des versions 
        if (!empty($remote_version) && version_compare($remote_version, $current_version, '>')) {
            if (!isset($transient->response)) $transient->response = [];

            $PACKAGE_URL = str_replace('.zip', '-' . $remote_version . '.zip', $OCADE_ZIP_URL);

            $transient->response[$theme_slug] = [
                'theme'       => $theme_slug,
                'new_version' => $remote_version,
                'url'         => $OCADE_THEME_REPO,
                'package'     => $PACKAGE_URL,
                'icons'       => $OCADE_ICONS,
            ];
        }

        return $transient;
    });

    add_action('upgrader_process_complete', function ($upgrader_object, $options) use ($OCADE_REMOTE_VERSION) {
        if ($options['action'] === 'update' && $options['type'] === 'theme') {
            delete_transient($OCADE_REMOTE_VERSION);
        }
    }, 10, 2);
};
