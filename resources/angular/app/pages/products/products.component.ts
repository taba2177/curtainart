import { Component, inject, OnInit, AfterViewInit, ElementRef, ViewChild, signal } from '@angular/core';
import { ApiService } from '../../core/services/api.service';
import { Post } from '../../core/models/types';

@Component({
  selector: 'app-products',
  standalone: true,
  imports: [],
  templateUrl: './products.component.html',
})
export class ProductsComponent implements OnInit, AfterViewInit {
  private readonly api = inject(ApiService);
  readonly posts = signal<Post[]>([]);

  @ViewChild('productSwiper') productSwiperEl!: ElementRef<HTMLElement>;
  private swiperInitialized = false;

  ngOnInit(): void {
    this.api.category('products').subscribe((res) => {
      this.posts.set(res.posts);
      this.initSwiper();
    });
  }

  ngAfterViewInit(): void {
    this.initSwiper();
  }

  private initSwiper(): void {
    if (this.swiperInitialized || !this.productSwiperEl) return;
    const SwipeLib = (window as any).Swiper;
    if (!SwipeLib || !this.posts().length) return;
    new SwipeLib(this.productSwiperEl.nativeElement, {
      slidesPerView: 'auto',
      spaceBetween: 24,
      pagination: { el: '.swiper-pagination', clickable: true },
      breakpoints: {
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1280: { slidesPerView: 4 },
      },
    });
    this.swiperInitialized = true;
  }

  getAr(field: Post['title']): string {
    if (typeof field === 'object') return (field as any).ar ?? (field as any).en ?? '';
    return field ?? '';
  }

  getImage(images: Post['images']): string {
    return (Array.isArray(images) ? images : [])[0] ?? '';
  }
}
