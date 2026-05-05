import { Component, inject, OnInit, signal } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';
import { ApiService } from '../../core/services/api.service';
import { NavItem } from '../../core/models/types';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterLink, RouterLinkActive],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.scss',
})
export class NavbarComponent implements OnInit {
  private readonly api = inject(ApiService);

  readonly navItems = signal<NavItem[]>([]);
  readonly logoUrl = signal('/images/curtainsart/logo.svg');
  readonly menuOpen = signal(false);

  ngOnInit(): void {
    this.api.navigation().subscribe((res) => {
      this.navItems.set(res.categories);
      if (res.logo) this.logoUrl.set(res.logo);
    });
  }

  toggleMenu(): void {
    this.menuOpen.update((v) => !v);
  }

  closeMenu(): void {
    this.menuOpen.set(false);
  }

  getLabel(name: NavItem['name']): string {
    if (typeof name === 'object') return name.ar ?? name.en ?? '';
    return name;
  }

  slugToPath(slug: string): string {
    return slug === 'homepage' ? '/' : `/${slug}`;
  }
}
