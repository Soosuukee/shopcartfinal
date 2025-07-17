import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Color } from '../models/color.interface';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class ColorService {
  private apiUrl = `${environment.apiUrl}/categories`;

  constructor(private http: HttpClient) {}

  getAllColors(): Observable<Color[]> {
    return this.http.get<Color[]>(this.apiUrl);
  }
}
