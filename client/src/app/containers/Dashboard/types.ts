/* --- STATE --- */
export interface DashboardState {
  selectedCustomer: boolean;
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
  date: string;
  recursive: boolean;
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

export type ContainerState = DashboardState;
