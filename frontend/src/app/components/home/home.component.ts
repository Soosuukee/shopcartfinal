import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { ProductListComponent } from './product-list/product-list.component';
import { FilterBarComponent } from './filter-bar/filter-bar.component';
import { CartService } from '../../services/cart.service';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ProductListComponent,
    FilterBarComponent,
  ],
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
})
export class HomeComponent implements OnInit {
  filters: {
    categoryId?: number;
    colorId?: number;
    materialId?: number;
    search?: string;
    sortPrice?: 'asc' | 'desc';
    showPromoted?: boolean;
  } = {};

  totalItems!: () => number;

  constructor(private cartService: CartService) {}

  ngOnInit(): void {
    this.totalItems = this.cartService.totalItems;
  }

  onFiltersChanged(event: {
    categoryId?: number;
    colorId?: number;
    materialId?: number;
    search?: string;
    sortPrice?: 'asc' | 'desc';
    showPromoted?: boolean;
  }) {
    this.filters = event;
  }
}
