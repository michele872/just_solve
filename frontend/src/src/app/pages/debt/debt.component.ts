import {Component, inject, OnInit} from '@angular/core';
import {DebtService} from '../../core/services/debt_service/debt-service.service';
import {CommonModule, CurrencyPipe, DatePipe, NgForOf} from '@angular/common';
import {Router} from '@angular/router';

@Component({
  selector: 'app-debt',
  standalone: true,
  imports: [CommonModule, DatePipe, CurrencyPipe],
  templateUrl: './debt.component.html',
  styleUrl: './debt.component.css'
})
export class DebtComponent implements OnInit{
  debts: any[] = [];
  private debtService = inject(DebtService);
  private router = inject(Router);

  ngOnInit(): void {
    this.debtService.getDebts().subscribe({
      next: (data) => this.debts = data,
      error: (err) => console.error(err)
    });
  }

  viewDetail(id: number) {
    this.router.navigate(['/debt', id]);
  }
}
