import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { HomeResponse, NavigationResponse, CategoryResponse, ContactPayload } from '../models/types';

@Injectable({ providedIn: 'root' })
export class ApiService {
  private readonly http = inject(HttpClient);
  private readonly base = '/api/v1';

  home(): Observable<HomeResponse> {
    return this.http.get<HomeResponse>(`${this.base}/home`);
  }

  navigation(): Observable<NavigationResponse> {
    return this.http.get<NavigationResponse>(`${this.base}/navigation`);
  }

  category(slug: string): Observable<CategoryResponse> {
    return this.http.get<CategoryResponse>(`${this.base}/categories/${slug}`);
  }

  contact(payload: ContactPayload): Observable<{ success: boolean }> {
    return this.http.post<{ success: boolean }>(`${this.base}/contact`, payload);
  }
}
