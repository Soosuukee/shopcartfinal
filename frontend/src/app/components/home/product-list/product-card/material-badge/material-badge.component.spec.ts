import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MaterialBadgeComponent } from './material-badge.component';

describe('MaterialBadgeComponent', () => {
  let component: MaterialBadgeComponent;
  let fixture: ComponentFixture<MaterialBadgeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MaterialBadgeComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MaterialBadgeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
