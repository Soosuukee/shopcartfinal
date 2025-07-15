import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Color } from '../models/color.interface';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ColorService {
  private apiUrl = 'http://34.38.251.201/colors';

  constructor(private http: HttpClient) {}

  getAllColors(): Observable<Color[]> {
    return this.http.get<Color[]>(this.apiUrl);
  }
}
