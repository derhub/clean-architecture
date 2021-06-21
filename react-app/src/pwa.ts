import { registerSW } from 'virtual:pwa-register';

registerSW({
  onOfflineReady() {
    // show a ready to work offline to user
  },
});
