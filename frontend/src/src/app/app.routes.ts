import { Routes } from '@angular/router';
import {DebtComponent} from './pages/debt/debt.component';
import {DebtDetailComponent} from './pages/debt-detail/debt-detail.component';

export const routes: Routes = [
  { path: '', component: DebtComponent, title: 'Debts' },
  { path: 'debt/:id', component: DebtDetailComponent, title: 'Debt Detail' },
  { path: '**', redirectTo: '' }
];
