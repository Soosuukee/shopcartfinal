// src/app/home/product-list/product-card/product-card.component.ts
import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Product } from '../../../../models/product.interface';
import { environment } from '../../../../../environments/environment';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-product-card',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './product-card.component.html',
  styleUrls: ['./product-card.component.scss'],
})
export class ProductCardComponent {
  @Input() product!: Product;
  imageBaseUrl = environment.imageBaseUrl;

  get finalPrice(): number {
    return this.product.price * (1 - this.product.promotion_percentage / 100);
  }
  onImgError(event: Event) {
    const img = event.target as HTMLImageElement;
    img.src = 'assets/images/default.jpg';
  }
}
