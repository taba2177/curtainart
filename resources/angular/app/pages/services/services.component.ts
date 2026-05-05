import { Component, inject, OnInit, signal } from '@angular/core';
import { ApiService } from '../../core/services/api.service';
import { Post } from '../../core/models/types';

@Component({
  selector: 'app-services',
  standalone: true,
  imports: [],
  templateUrl: './services.component.html',
})
export class ServicesComponent implements OnInit {
  private readonly api = inject(ApiService);
  readonly posts = signal<Post[]>([]);

  ngOnInit(): void {
    this.api.category('services').subscribe((res) => this.posts.set(res.posts));
  }

  getAr(field: Post['title']): string {
    if (typeof field === 'object') return (field as any).ar ?? (field as any).en ?? '';
    return field ?? '';
  }
}
