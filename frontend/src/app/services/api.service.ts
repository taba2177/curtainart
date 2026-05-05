import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map, shareReplay } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ApiService {
  private http = inject(HttpClient);

  private navigationCache$?: Observable<any>;

  private unwrapPayload<T>(response: any): T {
    if (response && typeof response === 'object' && 'data' in response) {
      return response.data as T;
    }
    return response as T;
  }

  private normalizeNavigationPayload(payload: any): { settings: any; categories: any[] } {
    if (!payload || typeof payload !== 'object') {
      return { settings: {}, categories: [] };
    }

    const groupedSettings = payload.settings && typeof payload.settings === 'object'
      ? payload.settings
      : {};

    const flatSettings = Object.values(groupedSettings).reduce((acc: any, value: any) => {
      if (value && typeof value === 'object' && !Array.isArray(value)) {
        return { ...acc, ...value };
      }
      return acc;
    }, {} as any);

    // The /api/v1/init endpoint returns categories under `navigation`, while
    // older shapes used `categories`. Pick whichever has items so an empty
    // `categories: []` doesn't shadow a populated `navigation` array.
    const fromCategories = Array.isArray(payload.categories) ? payload.categories : [];
    const fromNavigation = Array.isArray(payload.navigation) ? payload.navigation : [];
    const categories = fromCategories.length ? fromCategories : fromNavigation;

    return {
      settings: flatSettings,
      categories,
    };
  }

  getHome(): Observable<any> {
    return this.http.get('/api/v1/home').pipe(
      map((res) => this.unwrapPayload(res))
    );
  }

  getNavigation(): Observable<any> {
    if (!this.navigationCache$) {
      this.navigationCache$ = this.http.get('/api/v1/init').pipe(
        map((res) => this.unwrapPayload(res)),
        map((res) => this.normalizeNavigationPayload(res)),
        shareReplay(1)
      );
    }
    return this.navigationCache$;
  }

  getCategory(slug: string): Observable<any> {
    return this.http.get(`/api/v1/categories/${encodeURIComponent(slug)}`).pipe(
      map((res) => this.unwrapPayload(res))
    );
  }

  getPost(categorySlug: string, postSlug: string): Observable<any> {
    return this.http.get(`/api/v1/categories/${encodeURIComponent(categorySlug)}/${encodeURIComponent(postSlug)}`).pipe(
      map((res) => this.unwrapPayload(res))
    );
  }

  /**
   * Posts to /api/v1/contact. The backend validates `name`, `phone`, and
   * `message`; legacy `email`/`quiz` keys are accepted for backward
   * compatibility with older callers but ignored on the server.
   */
  submitContact(data: {
    name: string;
    phone?: string;
    message: string;
    email?: string;
    quiz?: string;
  }): Observable<any> {
    return this.http.post('/api/v1/contact', data).pipe(
      map((res) => this.unwrapPayload(res))
    );
  }
}
