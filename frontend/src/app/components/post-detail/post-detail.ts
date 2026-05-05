import { Component, computed, inject, signal, OnInit, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { Title, Meta } from '@angular/platform-browser';
import { ApiService } from '../../services/api.service';
import { t } from '../../utils/i18n';
import { ScrollRevealDirective } from '../../directives/scroll-reveal.directive';
import { LucideAngularModule, ArrowLeft, Phone, MessageCircle, Calendar, ShieldCheck, CheckCircle, Layers, Settings, Palette, Sparkles, X } from 'lucide-angular';
import { register } from 'swiper/element/bundle';

register();

/** Shape of the product metadata blob seeded into post.metadata. */
interface ProductMeta {
  subtitle?: string;
  gallery?: string[];
  types?: { name: string; description: string }[];
  materials?: string[];
  specs?: { title: string; description: string }[];
  features?: string[];
}

@Component({
  selector: 'app-post-detail',
  imports: [RouterLink, ScrollRevealDirective, LucideAngularModule],
  templateUrl: './post-detail.html',
  styleUrl: './post-detail.scss',
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
})
export class PostDetail implements OnInit {
  private api = inject(ApiService);
  private route = inject(ActivatedRoute);
  private titleSvc = inject(Title);
  private meta = inject(Meta);

  post = signal<any>(null);
  category = signal<any>(null);
  relatedPosts = signal<any[]>([]);
  settings = signal<any>({});
  loading = signal(true);
  lightboxImage = signal<string | null>(null);
  /** Currently displayed product gallery image (main viewer). */
  activeGalleryImage = signal<string | null>(null);
  t = t;

  // Icons
  readonly ArrowLeftIcon = ArrowLeft;
  readonly PhoneIcon = Phone;
  readonly WhatsAppIcon = MessageCircle;
  readonly CalendarIcon = Calendar;
  readonly ShieldCheckIcon = ShieldCheck;
  readonly CheckCircleIcon = CheckCircle;
  readonly LayersIcon = Layers;
  readonly SettingsIcon = Settings;
  readonly PaletteIcon = Palette;
  readonly SparklesIcon = Sparkles;
  readonly XIcon = X;

  /** Categories that drive the project-style gallery layout (large swiper). */
  private gallerySlugs = ['gallery', 'our-works', 'wooden-decorations', 'glass-facades', 'aluminum-works'];
  /** Categories that render as long-form articles. */
  private articleSlugs = ['about', 'services', 'partners', 'team', 'value-props', 'why-us', 'testimonials', 'clients', 'booking'];
  /** Categories that get the curtain-product detail layout. */
  private productSlugs = ['products'];

  get isGalleryLayout(): boolean {
    return this.gallerySlugs.includes(this.category()?.slug);
  }
  get isArticleLayout(): boolean {
    return this.articleSlugs.includes(this.category()?.slug);
  }
  get isProductLayout(): boolean {
    return this.productSlugs.includes(this.category()?.slug);
  }

  /**
   * Parse the post.metadata blob into a ProductMeta object. Handles three
   * shapes the backend might return: already-parsed object (Eloquent array
   * cast), a JSON string, or a translatable wrapper {en|ar: <obj>}.
   */
  productMeta = computed<ProductMeta | null>(() => {
    let m: any = this.post()?.metadata;
    if (!m) return null;
    if (typeof m === 'string') {
      try { m = JSON.parse(m); } catch { return null; }
    }
    if (m && typeof m === 'object' && !Array.isArray(m)) {
      // Unwrap translatable shape if present
      if (m.ar && typeof m.ar === 'object') m = m.ar;
      else if (m.en && typeof m.en === 'object') m = m.en;
    }
    return (m && typeof m === 'object' && !Array.isArray(m)) ? (m as ProductMeta) : null;
  });

  /**
   * Resolve the product gallery: prefer post.metadata.gallery (canonical
   * curated list), fall back to the generic post.images array on the model,
   * fall back finally to the singular post.image.
   */
  productGallery = computed<string[]>(() => {
    const meta = this.productMeta();
    if (meta?.gallery?.length) return meta.gallery;
    const imgs = (this.post()?.images || []).map((i: any) => i?.url || i).filter(Boolean);
    if (imgs.length) return imgs;
    const main = this.post()?.image?.url;
    return main ? [main] : [];
  });

  ngOnInit() {
    this.api.getNavigation().subscribe({
      next: (res: any) => this.settings.set(res.settings || {}),
    });

    this.route.params.subscribe(params => {
      this.loading.set(true);
      window.scrollTo({ top: 0 });
      this.api.getPost(params['category'], params['post']).subscribe({
        next: (res: any) => {
          this.post.set(res.post);
          this.category.set(res.category);
          this.relatedPosts.set(res.relatedPosts || []);
          this.loading.set(false);

          // Initialize product gallery viewer to the first image, if any.
          const first = this.productGallery()[0];
          if (first) this.activeGalleryImage.set(this.resolveImageUrl(first));

          const title = t(res.post?.meta_title) || t(res.post?.title) || '';
          const desc  = t(res.post?.meta_description) || t(res.post?.description) || '';
          const image = res.post?.image?.url || '';
          this.titleSvc.setTitle(title);
          this.meta.updateTag({ name: 'description', content: desc });
          this.meta.updateTag({ property: 'og:title', content: title });
          this.meta.updateTag({ property: 'og:description', content: desc });
          this.meta.updateTag({ property: 'og:image', content: image });
          this.meta.updateTag({ name: 'twitter:card', content: 'summary_large_image' });
          this.meta.updateTag({ name: 'twitter:title', content: title });
          this.meta.updateTag({ name: 'twitter:description', content: desc });
          this.meta.updateTag({ name: 'twitter:image', content: image });
          setTimeout(() => this.initSwiper(), 500);
        },
        error: () => this.loading.set(false),
      });
    });
  }

  /**
   * Map a metadata path string (e.g. /images/curtainsart/products/roll.webp)
   * to a runtime URL. Public-folder paths reach the storage symlink, so we
   * rewrite /images/curtainsart/... → /storage/images/curtainsart/...
   */
  resolveImageUrl(src: string): string {
    if (!src) return '';
    if (/^https?:\/\//.test(src)) return src;
    if (src.startsWith('/storage/')) return src;
    if (src.startsWith('/images/curtainsart/')) return '/storage' + src;
    return src;
  }

  setActiveGalleryImage(src: string): void {
    this.activeGalleryImage.set(this.resolveImageUrl(src));
  }

  private initSwiper() {
    const swiperEl = document.querySelector('swiper-container#detail-swiper') as any;
    if (swiperEl && !swiperEl.swiper) {
      Object.assign(swiperEl, {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 3,
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        coverflowEffect: { rotate: 5, stretch: 0, depth: 150, modifier: 1.5, slideShadows: true },
        pagination: { clickable: true },
        breakpoints: {
          320: { slidesPerView: 1.2 },
          640: { slidesPerView: 1.8 },
          1024: { slidesPerView: 2.5 },
        },
      });
      swiperEl.initialize();
    }
  }

  getImage(item: any): string {
    return item?.image?.url || item?.images?.[0]?.url || '/assets/images/default.jpg';
  }

  openLightbox(url: string) { this.lightboxImage.set(url); }
  closeLightbox() { this.lightboxImage.set(null); }

  /**
   * Build a WhatsApp deep link with a pre-filled inquiry about the current
   * product, so the customer just hits send and the rep knows exactly which
   * curtain type they're asking about.
   */
  whatsappLink(): string {
    const phone = (this.settings()?.crm_contact_whatsapp || this.settings()?.crm_contact_phone || '').toString().replace(/[^0-9]/g, '');
    const productName = t(this.post()?.title) || '';
    const text = encodeURIComponent(`السلام عليكم، أرغب بالاستفسار عن ${productName}`);
    return phone ? `https://wa.me/${phone}?text=${text}` : '#';
  }
}
