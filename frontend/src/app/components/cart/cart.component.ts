import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { CartService, CartItem } from '../../services/cart.service';
import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-cart',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.scss'],
})
export class CartComponent implements OnInit {
  cartItems!: () => CartItem[];
  totalItems!: () => number;
  totalPrice!: () => number;
  imageBaseUrl = environment.imageBaseUrl;

  constructor(private cartService: CartService, private router: Router) {}

  ngOnInit(): void {
    this.cartItems = this.cartService.items;
    this.totalItems = this.cartService.totalItems;
    this.totalPrice = this.cartService.totalPrice;
  }

  onImgError(event: Event): void {
    (event.target as HTMLImageElement).src = 'assets/images/default.jpg';
  }

  updateQuantity(productId: number, event: Event): void {
    const quantity = parseInt((event.target as HTMLInputElement).value);
    if (quantity > 0) {
      this.cartService.updateQuantity(productId, quantity);
    }
  }

  removeFromCart(productId: number): void {
    this.cartService.removeFromCart(productId);
  }

  clearCart(): void {
    this.cartService.clearCart();
  }

  trackById(index: number, item: CartItem): number {
    return item.product.id;
  }
  goToHome(): void {
    this.router.navigate(['/']);
  }
}
