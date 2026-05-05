import { Component, inject, OnInit, signal } from '@angular/core';
import { SettingsService } from '../../core/services/settings.service';

@Component({
  selector: 'app-footer',
  standalone: true,
  imports: [],
  templateUrl: './footer.component.html',
  styleUrl: './footer.component.scss',
})
export class FooterComponent implements OnInit {
  private readonly settings = inject(SettingsService);

  readonly socialLinks = signal<{ platform: string; url: string; icon: string }[]>([]);
  readonly footerDesc = signal('');
  readonly footerAddress = signal('');
  readonly copyright = signal('');
  readonly phone = signal('');

  ngOnInit(): void {
    this.socialLinks.set(this.settings.getSocialLinks());
    this.footerDesc.set(this.settings.get('footer_description'));
    this.footerAddress.set(this.settings.get('footer_address'));
    this.copyright.set(this.settings.get('footer_copyright'));
    this.phone.set(this.settings.get('contact_phone'));
  }
}
