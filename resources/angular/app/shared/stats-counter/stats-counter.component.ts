import { Component, input, OnInit, signal, ElementRef, inject } from '@angular/core';
import { Stat } from '../../core/models/types';

@Component({
  selector: 'app-stats-counter',
  standalone: true,
  imports: [],
  templateUrl: './stats-counter.component.html',
})
export class StatsCounterComponent implements OnInit {
  readonly stats = input<Stat[]>([]);

  readonly displayed = signal<number[]>([]);
  private readonly el = inject(ElementRef);

  ngOnInit(): void {
    this.displayed.set(this.stats().map(() => 0));
    this.observeAndAnimate();
  }

  private observeAndAnimate(): void {
    const observer = new IntersectionObserver(
      (entries) => {
        if (entries[0].isIntersecting) {
          this.animateAll();
          observer.disconnect();
        }
      },
      { threshold: 0.3 }
    );
    observer.observe(this.el.nativeElement);
  }

  private animateAll(): void {
    this.stats().forEach((stat, i) => {
      const target = stat.value;
      const step = Math.ceil(target / 60);
      let current = 0;
      const interval = setInterval(() => {
        current = Math.min(current + step, target);
        this.displayed.update((arr) => {
          const next = [...arr];
          next[i] = current;
          return next;
        });
        if (current >= target) clearInterval(interval);
      }, 25);
    });
  }
}
