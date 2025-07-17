import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Material } from '../models/material.interface';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class MaterialService {
  private apiUrl = `${environment.apiUrl}/materials`;

  constructor(private http: HttpClient) {}

  getAllMaterials(): Observable<Material[]> {
    return this.http.get<Material[]>(this.apiUrl);
  }
}
