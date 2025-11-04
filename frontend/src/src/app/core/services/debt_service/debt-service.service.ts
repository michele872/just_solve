import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DebtService {
  private apiUrl = 'http://localhost:8000/api/debts';

  constructor(private http: HttpClient) {}

  getDebts(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }

  getSuggestedAction(id: number): Observable<any> {
    return this.http.get(`${this.apiUrl}/${id}/suggest`);
  }

  applyAction(id: number, action: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/${id}/apply`, { action });
  }
}
