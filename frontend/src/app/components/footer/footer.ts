import { Component, inject, signal, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { ApiService } from '../../services/api.service';
import { t } from '../../utils/i18n';
import { LucideAngularModule, Phone, Mail, MapPin, Facebook, Twitter, Instagram, Linkedin } from 'lucide-angular';

@Component({
  selector: 'app-footer',
  imports: [RouterLink, LucideAngularModule],
  templateUrl: './footer.html',
  styleUrl: './footer.scss',
})
export class Footer implements OnInit {
  private api = inject(ApiService);
  categories = signal<any[]>([]);
  settings = signal<any>({});
  t = t;

  readonly PhoneIcon = Phone;
  readonly MailIcon = Mail;
  readonly MapPinIcon = MapPin;
  readonly FacebookIcon = Facebook;
  readonly TwitterIcon = Twitter;
  readonly InstagramIcon = Instagram;
  readonly LinkedinIcon = Linkedin;

  /**
   * Hardcoded primary nav — rendered immediately so the footer Quick Links
   * column always shows even before /api/v1/init resolves (or if that
   * request fails). Mirrors the navbar structure verbatim.
   */
  readonly quickLinks = [
    { label: 'الرئيسية',  path: '/' },
    { label: 'من نحن',    path: '/about' },
    { label: 'خدمات',      path: '/services' },
    { label: 'المنتجات',  path: '/products' },
    { label: 'اتصل بنا',  path: '/contact' },
  ];

  /** Curtain product sub-links — matches the original WP "منتجاتنا" footer column. */
  readonly productLinks = [
    { label: 'ستائر رول',     path: '/products/roll-curtains' },
    { label: 'ستائر أمريكي', path: '/products/american-curtains' },
    { label: 'ستائر خشبية',  path: '/products/wooden-curtains' },
    { label: 'ستائر معدنية', path: '/products/metal-curtains' },
    { label: 'ستائر زيبرا',  path: '/products/zebra-curtains' },
    { label: 'ألواح الشتر',  path: '/products/shutter-panels' },
  ];

  ngOnInit() {
    this.api.getNavigation().subscribe({
      next: (res: any) => {
        this.categories.set(res.categories || []);
        this.settings.set(res.settings || {});
      }
    });
  }

  // Public-folder paths (e.g. /images/curtainsart/logo.svg) are used directly;
  // any other value is treated as a media-library upload under /storage/.
  logoUrl(): string {
    const v = this.settings()?.crm_business_logo;
    if (!v) return '';
    return typeof v === 'string' && v.startsWith('/') ? v : '/storage/' + v;
  }
}
