import { Injectable, inject, signal } from '@angular/core';
import { ApiService } from './api.service';
import { Stat } from '../models/types';

@Injectable({ providedIn: 'root' })
export class SettingsService {
  private readonly api = inject(ApiService);
  private settings: Record<string, string> = {};

  readonly loaded = signal(false);

  load(): Promise<void> {
    return new Promise((resolve) => {
      this.api.navigation().subscribe((res) => {
        this.settings = res.settings ?? {};
        this.loaded.set(true);
        resolve();
      });
    });
  }

  get(key: string, fallback = ''): string {
    return this.settings[key] ?? fallback;
  }

  getStats(): Stat[] {
    try {
      return JSON.parse(this.get('about_stats', '[]'));
    } catch {
      return [];
    }
  }

  getSocialLinks(): { platform: string; url: string; icon: string }[] {
    try {
      return JSON.parse(this.get('social_links', '[]'));
    } catch {
      return [];
    }
  }
}
