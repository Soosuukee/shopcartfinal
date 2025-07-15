import { Component, EventEmitter, Output, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { CategoryService } from '../../../services/category.service';
import { ColorService } from '../../../services/color.service';
import { MaterialService } from '../../../services/material.service';
import { Category } from '../../../models/category.interface';
import { Color } from '../../../models/color.interface';
import { Material } from '../../../models/material.interface';

@Component({
  selector: 'app-filter-bar',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './filter-bar.component.html',
  styleUrls: ['./filter-bar.component.scss'],
})
export class FilterBarComponent {
  categories = signal<Category[]>([]);
  colors = signal<Color[]>([]);
  materials = signal<Material[]>([]);

  selectedCategoryId?: number;
  selectedColorId?: number;
  selectedMaterialId?: number;
  searchTerm: string = '';
  sortPrice?: 'asc' | 'desc';
  showPromoted: boolean = false;

  @Output() filterChange = new EventEmitter<{
    categoryId?: number;
    colorId?: number;
    materialId?: number;
    search?: string;
    sortPrice?: 'asc' | 'desc';
    showPromoted?: boolean;
  }>();

  constructor(
    private categoryService: CategoryService,
    private colorService: ColorService,
    private materialService: MaterialService
  ) {
    this.loadFilters();
  }

  loadFilters() {
    this.categoryService
      .getAllCategories()
      .subscribe((res) => this.categories.set(res));
    this.colorService.getAllColors().subscribe((res) => this.colors.set(res));
    this.materialService
      .getAllMaterials()
      .subscribe((res) => this.materials.set(res));
  }

  onFilterChange(
    categoryId?: string,
    colorId?: string,
    materialId?: string,
    sortPrice?: 'asc' | 'desc',
    showPromoted?: boolean
  ) {
    if (categoryId !== undefined) {
      this.selectedCategoryId = categoryId ? parseInt(categoryId) : undefined;
    }
    if (colorId !== undefined) {
      this.selectedColorId = colorId ? parseInt(colorId) : undefined;
    }
    if (materialId !== undefined) {
      this.selectedMaterialId = materialId ? parseInt(materialId) : undefined;
    }
    if (sortPrice !== undefined) {
      this.sortPrice = sortPrice || undefined;
    }
    if (showPromoted !== undefined) {
      this.showPromoted = showPromoted;
    }

    this.emitFilters();
  }

  onSearchChange(search: string) {
    this.searchTerm = search;
    this.emitFilters();
  }

  private emitFilters() {
    this.filterChange.emit({
      categoryId: this.selectedCategoryId,
      colorId: this.selectedColorId,
      materialId: this.selectedMaterialId,
      search: this.searchTerm.trim(),
      sortPrice: this.sortPrice,
      showPromoted: this.showPromoted,
    });
  }
}
