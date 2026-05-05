import { Component, inject, OnInit, signal } from '@angular/core';
import { ApiService } from '../../core/services/api.service';
import { StatsCounterComponent } from '../../shared/stats-counter/stats-counter.component';
import { SettingsService } from '../../core/services/settings.service';
import { Post } from '../../core/models/types';

@Component({
  selector: 'app-about',
  standalone: true,
  imports: [StatsCounterComponent],
  templateUrl: './about.component.html',
})
export class AboutComponent implements OnInit {
  private readonly api = inject(ApiService);
  private readonly settings = inject(SettingsService);

  readonly posts = signal<Post[]>([]);
  readonly stats = signal(this.settings.getStats());

  ngOnInit(): void {
    this.api.category('about').subscribe((res) => {
      this.posts.set(res.posts);
      const s = this.settings.getStats();
      if (s.length) this.stats.set(s);
    });
  }

  getAr(field: Post['title']): string {
    if (typeof field === 'object') return (field as any).ar ?? (field as any).en ?? '';
    return field ?? '';
  }

  getImage(images: Post['images']): string {
    return (Array.isArray(images) ? images : [])[0] ?? '';
  }
}
