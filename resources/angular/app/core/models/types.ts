export interface Post {
  id: number;
  slug: string;
  title: { en: string; ar: string } | string;
  content: { en: string; ar: string } | string;
  excerpt: { en: string; ar: string } | string;
  icon: string;
  images: string[];
  order: number;
}

export interface Category {
  id: number;
  slug: string;
  name: { en: string; ar: string } | string;
  section_component: string;
  posts?: Post[];
}

export interface NavItem {
  id: number;
  slug: string;
  name: { en: string; ar: string } | string;
  order: number;
}

export interface HomeResponse {
  metaTitle: string;
  sections: Category[];
}

export interface NavigationResponse {
  categories: NavItem[];
  settings: Record<string, string>;
  locale: string;
  logo: string;
  logoDark: string;
}

export interface CategoryResponse {
  category: Category;
  posts: Post[];
}

export interface ContactPayload {
  name: string;
  phone: string;
  message: string;
}

export interface Stat {
  value: number;
  label: string;
  suffix: string;
}
