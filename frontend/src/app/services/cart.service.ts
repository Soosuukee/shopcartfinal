// src/app/services/cart.service.ts
import { Injectable, computed, signal } from '@angular/core';
import { Product } from '../models/product.interface';

export interface CartItem {
  product: Product;
  quantity: number;
}

@Injectable({
  providedIn: 'root',
})
export class CartService {
  private cartItemsSignal = signal<CartItem[]>([]);

  readonly items = computed(() => this.cartItemsSignal());

  get totalItems() {
    return computed(() =>
      this.cartItemsSignal().reduce((sum, item) => sum + item.quantity, 0)
    );
  }

  get totalPrice() {
    return computed(() =>
      this.cartItemsSignal().reduce(
        (sum, item) =>
          sum +
          item.quantity *
            (item.product.price *
              (1 - item.product.promotion_percentage / 100)),
        0
      )
    );
  }

  getCart(): CartItem[] {
    return this.cartItemsSignal();
  }

  addToCart(product: Product): void {
    const current = this.cartItemsSignal();
    const index = current.findIndex((item) => item.product.id === product.id);

    if (index !== -1) {
      current[index].quantity++;
    } else {
      current.push({ product, quantity: 1 });
    }

    this.cartItemsSignal.set([...current]);
  }

  removeFromCart(productId: number): void {
    const current = this.cartItemsSignal().filter(
      (item) => item.product.id !== productId
    );
    this.cartItemsSignal.set(current);
  }

  updateQuantity(productId: number, quantity: number): void {
    const current = this.cartItemsSignal().map((item) =>
      item.product.id === productId ? { ...item, quantity } : item
    );
    this.cartItemsSignal.set(current);
  }

  clearCart(): void {
    this.cartItemsSignal.set([]);
  }
}
