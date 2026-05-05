import { Component, inject, OnInit, AfterViewInit, ElementRef, ViewChild, signal } from '@angular/core';
import { RouterLink } from '@angular/router';
import { ApiService } from '../../core/services/api.service';
import { SettingsService } from '../../core/services/settings.service';
import { StatsCounterComponent } from '../../shared/stats-counter/stats-counter.component';
import { Category, Post, Stat } from '../../core/models/types';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [RouterLink, StatsCounterComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss',
})
export class HomeComponent implements OnInit, AfterViewInit {
  private readonly api = inject(ApiService);
  private readonly settings = inject(SettingsService);

  @ViewChild('productSwiper') productSwiperEl!: ElementRef<HTMLElement>;

  readonly isLoading = signal(true);
  readonly heroPost = signal<Post | null>(null);
  readonly aboutPosts = signal<Post[]>([]);
  readonly servicePosts = signal<Post[]>([]);
  readonly productPosts = signal<Post[]>([]);
  readonly stats = signal<Stat[]>([]);
  readonly whatsappLink = signal('https://wa.me/966554373327');

  private swiperInitialized = false;

  ngOnInit(): void {
    this.api.home().subscribe({
      next: (res) => {
        const hero = res.sections.find(s => s.section_component === 'hero');
        this.heroPost.set(hero?.posts?.[0] ?? null);

        const about = res.sections.find(s => s.section_component === 'about');
        this.aboutPosts.set(about?.posts ?? []);

        const services = res.sections.find(s => s.section_component === 'services');
        this.servicePosts.set(services?.posts ?? []);

        const products = res.sections.find(s => s.section_component === 'products-carousel');
        this.productPosts.set(products?.posts ?? []);

        this.stats.set(this.parseStats());
        this.whatsappLink.set(this.settings.get('cta_whatsapp_link', 'https://wa.me/966554373327'));
        this.isLoading.set(false);
        this.initSwiper();
      },
      error: () => this.isLoading.set(false),
    });
  }

  ngAfterViewInit(): void {
    this.initSwiper();
  }

  private initSwiper(): void {
    if (this.swiperInitialized || !this.productSwiperEl) return;
    const SwipeLib = (window as any).Swiper;
    if (!SwipeLib) return;
    new SwipeLib(this.productSwiperEl.nativeElement, {
      slidesPerView: 'auto',
      spaceBetween: 24,
      pagination: { el: '.swiper-pagination', clickable: true },
    });
    this.swiperInitialized = true;
  }

  private parseStats(): Stat[] {
    const raw = this.settings.getStats();
    if (raw.length) return raw;
    return [
      { value: 900, label: 'مشروع منجز', suffix: '+' },
      { value: 2000, label: 'عميل موثوق', suffix: '+' },
      { value: 47, label: 'جهة حكومية', suffix: '+' },
      { value: 10, label: 'سنوات خبرة', suffix: '+' },
    ];
  }

  getAr(field: Post['title']): string {
    if (typeof field === 'object') return (field as any).ar ?? (field as any).en ?? '';
    return field ?? '';
  }

  getImage(images: Post['images']): string {
    const list = Array.isArray(images) ? images : [];
    return list[0] ?? '';
  }
}
