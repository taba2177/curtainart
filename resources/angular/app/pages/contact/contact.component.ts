import { Component, inject, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../core/services/api.service';
import { SettingsService } from '../../core/services/settings.service';

@Component({
  selector: 'app-contact',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './contact.component.html',
})
export class ContactComponent {
  private readonly api = inject(ApiService);
  private readonly settings = inject(SettingsService);

  readonly form = signal({ name: '', phone: '', message: '' });
  readonly isSubmitting = signal(false);
  readonly submitted = signal(false);
  readonly error = signal('');
  readonly phone = signal('+966554373327');
  readonly whatsapp = signal('https://wa.me/966554373327');
  readonly address = signal('طريق الصحابة، حي اشبيلية، الرياض 13225');

  submit(): void {
    const f = this.form();
    if (!f.name || !f.phone || !f.message) {
      this.error.set('يرجى ملء جميع الحقول');
      return;
    }
    this.error.set('');
    this.isSubmitting.set(true);

    this.api.contact(f).subscribe({
      next: () => {
        this.submitted.set(true);
        this.isSubmitting.set(false);
        this.form.set({ name: '', phone: '', message: '' });
      },
      error: () => {
        this.error.set('حدث خطأ، يرجى المحاولة مرة أخرى');
        this.isSubmitting.set(false);
      },
    });
  }

  updateField(field: 'name' | 'phone' | 'message', value: string): void {
    this.form.update((f) => ({ ...f, [field]: value }));
  }
}
