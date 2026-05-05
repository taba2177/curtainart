import { Component, inject, signal, OnInit } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';
import { ApiService } from '../../services/api.service';
import { t } from '../../utils/i18n';
import { LucideAngularModule, Phone, Menu, X } from 'lucide-angular';

@Component({
  selector: 'app-header',
  imports: [RouterLink, RouterLinkActive, LucideAngularModule],
  templateUrl: './header.html',
  styleUrl: './header.scss',
})
export class Header implements OnInit {
  private api = inject(ApiService);
  categories = signal<any[]>([]);
  settings = signal<any>({});
  mobileMenuOpen = signal(false);
  t = t;

  readonly PhoneIcon = Phone;
  readonly MenuIcon = Menu;
  readonly XIcon = X;

  /**
   * Hardcoded primary nav — rendered directly by the template so the navbar
   * never depends on /api/v1/init resolving. Matches the upstream WP nav
   * order: الرئيسية / من نحن / خدمات / المنتجات / اتصل بنا.
   */
  readonly navLinks = [
    { label: 'الرئيسية',  path: '/',         exact: true  },
    { label: 'من نحن',    path: '/about',    exact: false },
    { label: 'خدمات',      path: '/services', exact: false },
    { label: 'المنتجات',  path: '/products', exact: false },
    { label: 'اتصل بنا',  path: '/contact',  exact: false },
  ];

  ngOnInit() {
    // The categories signal is no longer used by the template, but kept
    // populated for any consumer that still reads it. settings() is still
    // needed for the WhatsApp/phone CTA buttons in the actions row.
    this.api.getNavigation().subscribe({
      next: (res: any) => {
        this.categories.set((res.categories || []).filter((c: any) => c.slug !== 'contact'));
        this.settings.set(res.settings || {});
      },
    });
  }

  toggleMobileMenu() {
    this.mobileMenuOpen.update(v => !v);
  }

  // Public-folder paths (e.g. /images/curtainsart/logo.svg) are used directly;
  // any other value is treated as a media-library upload under /storage/.
  logoUrl(): string {
    const v = this.settings()?.crm_business_logo;
    if (!v) return '';
    return typeof v === 'string' && v.startsWith('/') ? v : '/storage/' + v;
  }
}
