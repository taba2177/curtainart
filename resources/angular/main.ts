import { bootstrapApplication } from '@angular/platform-browser';
import { appConfig } from './app/app.config';
import { App } from './app/app';
// @ts-ignore — vendored Swiper.js, no type definitions
import '../js/swiper.min.js';

bootstrapApplication(App, appConfig)
  .catch((err) => console.error(err));
