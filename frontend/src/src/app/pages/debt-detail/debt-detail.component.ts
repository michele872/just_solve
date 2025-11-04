import {Component, inject, OnInit} from '@angular/core';
import {ActivatedRoute, Router, RouterLink} from '@angular/router';
import {DebtService} from '../../core/services/debt_service/debt-service.service';
import {DecimalPipe, NgIf} from '@angular/common';

@Component({
  selector: 'app-debt-detail',
  imports: [
    NgIf,
    DecimalPipe,
    RouterLink
  ],
  templateUrl: './debt-detail.component.html',
  styleUrl: './debt-detail.component.css'
})
export class DebtDetailComponent implements OnInit {
  debtId!: number;
  suggestion: any;
  message: string = '';
  private route = inject(ActivatedRoute);
  private debtService = inject(DebtService);
  private router = inject(Router);

  ngOnInit(): void {
    this.debtId = Number(this.route.snapshot.paramMap.get('id'));
    this.loadSuggestion();
  }

  loadSuggestion() {
    this.debtService.getSuggestedAction(this.debtId).subscribe({
      next: (data) => this.suggestion = data,
      error: (err) => console.error(err)
    });
  }

  applyAction(action: string) {
    this.debtService.applyAction(this.debtId, action).subscribe({
      next: (res) => {
        this.message = res.message;
        setTimeout(() => this.router.navigate(['/']), 1500);
      },
      error: err => console.error('Errore API:', err.error, err.message, err.status)
    });
  }
}
