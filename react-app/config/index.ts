export const PWA_CONFIG = {
  registerType: 'autoUpdate',
  workbox: {
    additionalManifestEntries: [
      {
        url: 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;0,700;0,900;1,100;1,400;1,700;1,900&display=swap',
        revision: null,
      },
    ],
    cleanupOutdatedCaches: true,
    navigateFallback: undefined,
  },
  manifest: {
    name: 'Clean App',
    short_name: 'CleanApp',
    theme_color: '#BD34FE',
    icons: [
      {
        src: '/android-chrome-192x192.png',
        sizes: '192x192',
        type: 'image/png',
        purpose: 'any maskable',
      },
      {
        src: '/android-chrome-512x512.png',
        sizes: '512x512',
        type: 'image/png',
      },
    ],
  },
};
