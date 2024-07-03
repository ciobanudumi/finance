import * as React from 'react';
import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { reducer, sliceKey, summaryActions } from './slice';
import { summarySaga } from './saga';
import { useDispatch, useSelector } from 'react-redux';
import { Helmet } from 'react-helmet-async';
import { useEffect, useState } from 'react';
import { selectTransactions } from './selectors';
import { CCard, CCardBody, CCardHeader, CCol, CRow } from '@coreui/react';
import { CChart } from '@coreui/react-chartjs';
import { getStyle } from 'chart.js/helpers';
import { AmountPerMonths } from './types';

export default function Dashboard() {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: summarySaga });
  const dispatch = useDispatch();

  const [totalIncome, setTotalIncome] = useState(0);
  const [totalExpenses, setTotalExpenses] = useState(0);
  const [remainingBalance, setRemainingBalance] = useState(0);
  const [incomePerMonths, setIncomePerMonths] = useState([] as number[]);
  const [expensePerMonths, setExpensePerMonths] = useState([] as number[]);
  const [expensePerCategories, setExpensePerCategories] = useState([] as AmountPerMonths[]);
  const transactions = useSelector(selectTransactions);

  const months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
  ];

  const categories = [
    'Meal',
    'Distraction',
    'Transport',
    'Bills',
    'Shopping',
    'Healthcare',
    'Education',
    'Travel',
    'Entertainment',
    'Utilities',
    'Insurance',
    'Rent',
    'Stocks ',
    'ETF ',
    'Dividends ',
    'Salary ',
    'Rental Income',
  ];

  useEffect(() => {
    setTotalIncome(
      transactions.reduce(function (acc, current) {
        if (current.type === 'income') {
          return acc + current.amount;
        } else {
          return acc;
        }
      }, 0),
    );

    setTotalExpenses(
      transactions.reduce(function (acc, current) {
        if (current.type === 'expense') {
          return acc + current.amount;
        } else {
          return acc;
        }
      }, 0),
    );
  }, [dispatch, transactions]);

  useEffect(() => {
    let am = [] as number[];
    months.forEach(month => {
      am.push(
        transactions.reduce(function (acc, current) {
          var date = new Date(current.date);

          var monthName = new Intl.DateTimeFormat('en-US', { month: 'long' }).format;
          var longName = monthName(date);
          if (month === longName && current.type === 'income') {
            return acc + current.amount;
          } else {
            return acc;
          }
        }, 0),
      );
    });
    setIncomePerMonths(am);
  }, [transactions]);

  useEffect(() => {
    let am = [] as number[];
    months.forEach(month => {
      am.push(
        transactions.reduce(function (acc, current) {
          var date = new Date(current.date);

          var monthName = new Intl.DateTimeFormat('en-US', { month: 'long' }).format;
          var longName = monthName(date);
          if (month === longName && current.type === 'expense') {
            return acc + current.amount;
          } else {
            return acc;
          }
        }, 0),
      );
    });
    setExpensePerMonths(am);
  }, [transactions]);

  useEffect(() => {
    let am = [] as AmountPerMonths[];
    categories.forEach(cat => {
      let amount = transactions.reduce(function (acc, current) {
        if (cat === current.category.name.trim() && current.type === 'expense') {
          return acc + current.amount;
        } else {
          return acc;
        }
      }, 0);

      am.push({ name: cat.trim(), amount: amount });
    });
    am.sort((a, b) => {
      if (a.amount > b.amount) {
        return -1;
      } else if (a.amount < b.amount) {
        return 1;
      }
      return 0;
    });
    am = am.slice(0, 5);
    setExpensePerCategories(am);
    console.log('test sdsadas', am);
  }, [transactions]);

  useEffect(() => {
    setRemainingBalance(totalIncome - totalExpenses);
  }, [totalExpenses, totalIncome]);

  useEffect(() => {
    console.log('test', transactions);
  }, [transactions]);

  useEffect(() => {
    dispatch(summaryActions.getTransactions());
  }, [dispatch]);

  // @ts-ignore
  return (
    <>
      <Helmet>
        <title>Summary</title>
      </Helmet>
      <h3>Summary for the last Year</h3>
      <CRow>
        <CCol md={6}>
          <CCard className="mb-4">
            <CCardHeader>For Last Year</CCardHeader>
            <CCardBody>
              <CChart
                type="doughnut"
                data={{
                  labels: ['Income', 'Expense', 'Remain'],
                  datasets: [
                    {
                      backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
                      data: [totalIncome, totalExpenses, remainingBalance],
                    },
                  ],
                }}
                options={{
                  plugins: {
                    legend: {
                      labels: {
                        color: 'primary',
                      },
                    },
                  },
                }}
              />
            </CCardBody>
          </CCard>
        </CCol>
        <CCol md={6}>
          <CCard className="mb-4">
            <CCardHeader>Most expensive expenses</CCardHeader>
            <CCardBody>
              <CChart
                type="polarArea"
                data={{
                  labels: expensePerCategories.map(category => {
                    return category.name;
                  }),
                  datasets: [
                    {
                      data: expensePerCategories.map(category => {
                        return category.amount;
                      }),
                      backgroundColor: ['#FF6384', '#4BC0C0', '#FFCE56', '#E7E9ED', '#36A2EB'],
                    },
                  ],
                }}
                options={{
                  plugins: {
                    legend: {
                      labels: {
                        color: 'primary',
                      },
                    },
                  },
                  scales: {
                    r: {
                      grid: {
                        color: 'primary',
                      },
                    },
                  },
                }}
              />
            </CCardBody>
          </CCard>
        </CCol>
        <CCol md={6}>
          <CCard className="mb-4">
            <CCardHeader>Monthly Summary</CCardHeader>
            <CCardBody>
              <CChart
                type="bar"
                data={{
                  labels: months,
                  datasets: [
                    {
                      label: 'Income',
                      backgroundColor: '#41B883FF',
                      data: incomePerMonths,
                    },
                  ],
                }}
                options={{
                  plugins: {
                    legend: {
                      labels: {
                        color: 'primary',
                      },
                    },
                  },
                  scales: {
                    x: {
                      grid: {
                        color: 'primary',
                      },
                      ticks: {
                        color: 'primary',
                      },
                    },
                    y: {
                      grid: {
                        color: 'primary',
                      },
                      ticks: {
                        color: 'primary',
                      },
                    },
                  },
                }}
              />
            </CCardBody>
          </CCard>
        </CCol>
        <CCol md={6}>
          <CCard className="mb-4">
            <CCardHeader>Monthly Summary</CCardHeader>
            <CCardBody>
              <CChart
                type="bar"
                data={{
                  labels: months,
                  datasets: [
                    {
                      label: 'Expenses',
                      backgroundColor: '#f87979',
                      data: expensePerMonths,
                    },
                  ],
                }}
                options={{
                  plugins: {
                    legend: {
                      labels: {
                        color: 'primary',
                      },
                    },
                  },
                  scales: {
                    x: {
                      grid: {
                        color: 'primary',
                      },
                      ticks: {
                        color: 'primary',
                      },
                    },
                    y: {
                      grid: {
                        color: 'primary',
                      },
                      ticks: {
                        color: 'primary',
                      },
                    },
                  },
                }}
              />
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </>
  );
}
