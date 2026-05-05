import { Component, inject, signal, OnInit, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Title, Meta } from '@angular/platform-browser';
import { ApiService } from '../../services/api.service';
import { t } from '../../utils/i18n';
import { LucideAngularModule, ArrowLeft, ArrowRight, ShieldCheck, PenTool, CheckCircle, ChevronRight, Phone, MessageCircle, Download, Star, Quote, Calendar, Send, Users, Building2, Briefcase, MessageSquare, Tag, Truck, Wrench, Brush } from 'lucide-angular';
import { RouterLink } from '@angular/router';
import { ScrollRevealDirective } from '../../directives/scroll-reveal.directive';
import { register } from 'swiper/element/bundle';

register();

@Component({
  selector: 'app-home',
  imports: [CommonModule, FormsModule, LucideAngularModule, RouterLink, ScrollRevealDirective],
  templateUrl: './home.html',
  styleUrl: './home.scss',
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
})
export class Home implements OnInit {
  private api = inject(ApiService);
  private titleSvc = inject(Title);
  private meta = inject(Meta);
  public data = signal<any>(null);
  public settings = signal<any>({});
  public t = t;

  /**
   * crm_business_stats arrives as either a JSON-encoded string (raw DB value)
   * or an already-parsed array depending on the backend cast. Normalise both
   * shapes so the hero stats bar can iterate the result safely.
   */
  public stats = (): Array<{ value: string; label: any }> => {
    const raw = this.settings()?.crm_business_stats;
    if (!raw) return [];
    if (Array.isArray(raw)) return raw;
    if (typeof raw === 'string') {
      try { const parsed = JSON.parse(raw); return Array.isArray(parsed) ? parsed : []; }
      catch { return []; }
    }
    return [];
  };

  // Icons
  readonly ArrowLeftIcon = ArrowLeft;
  readonly ArrowRightIcon = ArrowRight;
  readonly ShieldCheckIcon = ShieldCheck;
  readonly PenToolIcon = PenTool;
  readonly CheckCircleIcon = CheckCircle;
  readonly ChevronRightIcon = ChevronRight;
  readonly PhoneIcon = Phone;
  readonly WhatsAppIcon = MessageCircle;
  readonly DownloadIcon = Download;
  readonly StarIcon = Star;
  readonly QuoteIcon = Quote;
  readonly CalendarIcon = Calendar;
  readonly SendIcon = Send;
  readonly UsersIcon = Users;
  readonly BuildingIcon = Building2;
  readonly BriefcaseIcon = Briefcase;

  /** Curtain types listed under the hero — verbatim from upstream WP. */
  readonly productTypes = [
    'ستائر رول', 'ستائر أمريكي', 'ستائر خشبية', 'ستائر معدنية',
    'ستائر عمودية', 'ستائر روماني', 'ستائر زيبرا', 'ألواح شتر',
  ];

  /**
   * Pick the right Lucide icon for each service card from the post's `icon`
   * field (or its slug as a fallback). Each service gets a distinct icon so
   * the services grid reads as 6 distinct concepts, not a row of clones.
   */
  serviceIconFor(post: any): any {
    const key = (post?.icon || post?.slug || '').toString();
    const map: Record<string, any> = {
      'shield-check':         ShieldCheck,
      'service-warranty':     ShieldCheck,
      'chat-bubble':          MessageSquare,
      'service-consultation': MessageSquare,
      'tag':                  Tag,
      'service-pricing':      Tag,
      'truck':                Truck,
      'service-visit':        Truck,
      'paint-brush':          Brush,
      'service-custom':       Brush,
      'wrench':               Wrench,
      'service-installation': Wrench,
    };
    return map[key] || ShieldCheck;
  }

  /** Spaces served — surfaced as inline pills in the about section. */
  readonly aboutSpaces = ['منازل سكنية', 'مكاتب وشركات', 'جهات حكومية', 'مستشفيات'];

  // ── Inline booking form (booking-form section_component) ──────────────
  // Three fields mirror the upstream WP home form: name / phone / district.
  // Submits to the same /api/v1/contact endpoint the dedicated /contact
  // page uses; `district` is concatenated into the message body since the
  // controller validation is name/phone/message-only.
  bookingName = '';
  bookingPhone = '';
  bookingDistrict = '';
  bookingSubmitting = signal(false);
  bookingSuccess = signal(false);
  bookingError = signal('');

  submitBooking(event: Event): void {
    event.preventDefault();
    this.bookingError.set('');
    this.bookingSuccess.set(false);

    if (!this.bookingName || !this.bookingPhone || !this.bookingDistrict) {
      this.bookingError.set('يرجى ملء جميع الحقول');
      return;
    }

    this.bookingSubmitting.set(true);
    this.api.submitContact({
      name: this.bookingName,
      phone: this.bookingPhone,
      message: `طلب زيارة مجانية — الحي: ${this.bookingDistrict}`,
    }).subscribe({
      next: () => {
        this.bookingSuccess.set(true);
        this.bookingSubmitting.set(false);
        this.bookingName = '';
        this.bookingPhone = '';
        this.bookingDistrict = '';
      },
      error: (err) => {
        this.bookingSubmitting.set(false);
        const errors = err?.error?.errors;
        this.bookingError.set(errors
          ? Object.values(errors).flat().join(', ')
          : 'حدث خطأ، حاول مجدداً');
      },
    });
  }

  private mapLegacySectionComponent(component: string): string {
    switch (component) {
      case 'hero-section':
        return 'hero';
      case 'about-section':
        return 'about';
      case 'services-section':
        return 'our-service';
      case 'projects-section':
        return 'our-projects';
      case 'features-section':
        return 'why-choose-us';
      case 'partners-section':
        return 'four-cards';
      default:
        return (component || '').replace('-section', '');
    }
  }

  private normalizeHomePayload(payload: any): any {
    if (!payload || typeof payload !== 'object') {
      return { sections: [] };
    }

    if (Array.isArray(payload.sections)) {
      return payload;
    }

    const categories = Array.isArray(payload.categories) ? payload.categories : [];
    const sections = categories.map((category: any) => ({
      ...category,
      section_component: this.mapLegacySectionComponent(category.section_component || ''),
      posts: Array.isArray(category.posts) ? category.posts : [],
    }));

    const featuredPosts = Array.isArray(payload.featured_posts) ? payload.featured_posts : [];
    if (featuredPosts.length > 0 && !sections.some((s: any) => s.section_component === 'hero')) {
      sections.unshift({
        id: 'hero-section',
        name: 'Hero',
        slug: '',
        section_component: 'hero',
        posts: [featuredPosts[0]],
      });
    }

    return {
      ...payload,
      sections,
    };
  }

  ngOnInit() {
    this.api.getHome().subscribe({
      next: (response: any) => {
        this.data.set(this.normalizeHomePayload(response));
        // Init Swiper after Angular renders the template
        setTimeout(() => this.initSwiper(), 500);
      },
      error: (err) => {
        console.error('Error fetching home data:', err);
      }
    });

    this.api.getNavigation().subscribe({
      next: (res: any) => {
        this.settings.set(res.settings || {});
        const s = res.settings || {};
        const name = t(s.crm_seo_default_title) || t(s.crm_business_name) || 'مصنع فن الستارة';
        const desc = t(s.crm_seo_default_description) || t(s.crm_business_description) || '';
        const image = t(s.crm_business_logo) || '';
        this.titleSvc.setTitle(name);
        this.meta.updateTag({ name: 'description', content: desc });
        this.meta.updateTag({ property: 'og:title', content: name });
        this.meta.updateTag({ property: 'og:description', content: desc });
        this.meta.updateTag({ property: 'og:image', content: image });
        this.meta.updateTag({ property: 'og:type', content: 'website' });
      }
    });
  }

  private initSwiper() {
    const swiperEl = document.querySelector('swiper-container#works-swiper') as any;
    if (swiperEl && !swiperEl.swiper) {
      Object.assign(swiperEl, {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 3,
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        coverflowEffect: {
          rotate: 8,
          stretch: 0,
          depth: 200,
          modifier: 1.5,
          slideShadows: true,
        },
        pagination: { clickable: true },
        breakpoints: {
          320: { slidesPerView: 1.2 },
          640: { slidesPerView: 1.8 },
          1024: { slidesPerView: 2.5 },
          1440: { slidesPerView: 3 },
        },
      });
      swiperEl.initialize();
    }
  }

  getSectionData(componentName: string): any {
    if (!this.data()?.sections) return null;
    return this.data().sections.find((s: any) => s.section_component === componentName) || null;
  }
}
