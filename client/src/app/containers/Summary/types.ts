/* --- STATE --- */
export interface SummaryState {
  transactions: Transaction[];
  totalTransactionsCount: number | null;
  period: Period;
}

export interface Period {
  startDate: string | null;
  endDate: string | null;
}

export interface Category {
  id: string;
  name: string;
}

export interface Transaction {
  id: string;
  amount: number;
  description: string;
  type: string;
  category: Category;
  recursive: boolean;
  date: string;
}

export interface TransactionsResponse {
  data: {
    transactions: {
      edges: {
        node: {
          transaction: Transaction[];
        };
      };
      totalCount: number;
    };
  };
}

export interface AmountPerMonths {
  name: string;
  amount: number;
}

export type ContainerState = SummaryState;
