import { Category } from "./category.interface";
import { Color } from "./color.interface";
import { Material } from "./material.interface";


export interface Product {
  id: number;
  name: string;
  image: string;
  short_description: string;
  price: number;
  promotion_percentage: number;
  category: Category;
  colors: Color[];
  materials: Material[];
}
