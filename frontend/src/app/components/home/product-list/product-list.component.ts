import {
  Component,
  Input,
  OnChanges,
  SimpleChanges,
  signal,
} from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProductCardComponent } from './product-card/product-card.component';
import { ProductService } from '../../../services/product.service';
import { Product } from '../../../models/product.interface';

@Component({
  selector: 'app-product-list',
  standalone: true,
  imports: [CommonModule, ProductCardComponent],
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss'],
})
export class ProductListComponent implements OnChanges {
  @Input() filters: {
    categoryId?: number;
    colorId?: number;
    materialId?: number;
    search?: string;
    sortPrice?: 'asc' | 'desc';
    showPromoted?: boolean;
  } = {};

  private allProducts: Product[] = [];
  products = signal<Product[]>([]);

  constructor(private productService: ProductService) {
    this.loadProducts();
  }

  loadProducts() {
    this.productService.getAllProducts().subscribe((res) => {
      this.allProducts = res;
      this.applyFilters();
    });
  }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes['filters']) {
      this.applyFilters();
    }
  }

  applyFilters() {
    const { categoryId, colorId, materialId, search, sortPrice, showPromoted } =
      this.filters;
    const searchTerm = (search ?? '').toLowerCase();

    let filtered = this.allProducts.filter((product) => {
      const matchCategory = !categoryId || product.category.id === categoryId;
      const matchColor =
        !colorId || product.colors.some((c) => c.id === colorId);
      const matchMaterial =
        !materialId || product.materials.some((m) => m.id === materialId);
      const matchSearch =
        !searchTerm || product.name.toLowerCase().includes(searchTerm);
      const matchPromoted = !showPromoted || product.promotion_percentage > 0;

      return (
        matchCategory &&
        matchColor &&
        matchMaterial &&
        matchSearch &&
        matchPromoted
      );
    });

    if (sortPrice) {
      filtered.sort((a, b) =>
        sortPrice === 'asc' ? a.price - b.price : b.price - a.price
      );
    }

    this.products.set(filtered);
  }
}
