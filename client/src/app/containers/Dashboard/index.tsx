import * as React from 'react';
import { useEffect, useState } from 'react';
import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { dashboardActions, reducer, sliceKey } from './slice';
import { dashboardSaga } from './saga';
import { useDispatch, useSelector } from 'react-redux';
import { selectFocus, selectLoading, selectUser } from '../App/selectors';
import { Helmet } from 'react-helmet-async';
import { useTranslation } from 'react-i18next';
import {
  CCol,
  CDatePicker,
  CDropdown,
  CDropdownItem,
  CDropdownMenu,
  CDropdownToggle,
  CRow,
  CSmartTable,
  CWidgetStatsA,
} from '@coreui/react-pro';
import CIcon from '@coreui/icons-react';
import { cilArrowBottom, cilArrowTop, cilOptions, cilPencil, cilTrash } from '@coreui/icons';
import {
  CBadge,
  CButton,
  CCardBody,
  CCollapse,
  CForm,
  CFormInput,
  CFormLabel,
  CFormSelect,
  CFormTextarea,
  CModal,
  CModalBody,
  CModalHeader,
  CModalTitle,
  CNav,
  CNavItem,
  CNavLink,
} from '@coreui/react';
import { selectPeriod, selectTotalTransactionsCount, selectTransactions } from './selectors';
import { use } from 'i18next';
import { useMutation } from '@apollo/client';
import { DELETE_TRANSACTIONS_QUERY } from '../../graphql-queries/transactions';
import { appActions } from '../App/slice';
import notificationBuilder from '../../../utils/notificationBuilder';
import { Form } from 'react-hook-form';
import { Transaction } from './types';

export default function Dashboard() {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: dashboardSaga });
  const { t } = useTranslation();
  const user = useSelector(selectUser);
  const dispatch = useDispatch();

  const focus = useSelector(selectLoading);
  const transactions = useSelector(selectTransactions);
  const transactionsCount = useSelector(selectTotalTransactionsCount);
  const period = useSelector(selectPeriod);

  const [totalIncome, setTotalIncome] = useState(0);
  const [totalExpenses, setTotalExpenses] = useState(0);
  const [remainingBalance, setRemainingBalance] = useState(0);
  const [showAddModal, setShowAddModal] = useState(false);
  const [showEditModal, setShowEditModal] = useState(false);
  const [editTransaction, setEditTransaction] = useState(null as unknown as Transaction);

  const [activetab, setActiveTab] = useState(0);

  const [deleteTransactions] = useMutation(DELETE_TRANSACTIONS_QUERY);

  const onDelete = async id => {
    dispatch(appActions.startFormSubmitting());
    const variables = {
      id: id,
    };
    const response = await deleteTransactions({ variables });
    console.log('test id', id, response);
    if (!response['data']) {
      dispatch(appActions.addNotification(notificationBuilder('danger', 'Error Delete transaction', 'Error')));
    } else {
      dispatch(appActions.addNotification(notificationBuilder('success', 'Transaction have been deleted', 'Success')));
    }
    dispatch(dashboardActions.getTransactions());
    dispatch(appActions.stopFormSubmitting());
  };

  useEffect(() => {
    dispatch(dashboardActions.getTransactions());
  }, [period]);

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
    setRemainingBalance(totalIncome - totalExpenses);
  }, [totalExpenses, totalIncome]);

  useEffect(() => {
    dispatch(dashboardActions.getTransactions());
  }, [dispatch]);

  const [details, setDetails] = useState([]);
  const columns = [
    {
      key: 'date',
      filter: false,
      sorter: false,
    },
    {
      key: 'recursive',
      label: 'Recursive',
      filter: false,
      sorter: false,
    },
    {
      key: 'type',
      label: 'Type',
      filter: false,
      sorter: false,
    },
    {
      key: 'amount',
      label: 'Amount',
      _style: { width: '20%' },
      filter: false,
      sorter: false,
    },
    {
      key: 'category',
      filter: false,
      sorter: false,
      _style: { width: '20%' },
    },
    {
      key: 'show_details',
      label: '',
      _style: { width: '2%' },
      filter: false,
      sorter: false,
    },
  ];

  const getBadge = status => {
    switch (status) {
      case 'Active':
        return 'success';
      case 'Inactive':
        return 'secondary';
      case 'Pending':
        return 'warning';
      case 'Banned':
        return 'danger';
      default:
        return 'primary';
    }
  };
  const toggleDetails = index => {
    // @ts-ignore
    const position = details.indexOf(index);
    let newDetails = details.slice();
    if (position !== -1) {
      newDetails.splice(position, 1);
    } else {
      // @ts-ignore
      newDetails = [...details, index];
    }
    setDetails(newDetails);
  };

  // @ts-ignore
  // @ts-ignore
  return (
    <>
      <Helmet>
        <title>Dashboard</title>
      </Helmet>
      <CModal visible={showAddModal} onClose={() => setShowAddModal(false)}>
        <CModalHeader closeButton>
          <CModalTitle>Add transactions</CModalTitle>
        </CModalHeader>
        <CModalBody>
          <CForm
            onSubmit={event => {
              event.preventDefault();
              console.log('test event', event);
            }}
          >
            <CFormInput type="number" id="amount" label="Amount" defaultValue={0} />
            <CFormLabel className="mt-2">Type</CFormLabel>
            <CFormSelect
              aria-label="Type"
              options={[
                { label: 'Income', value: 'income' },
                { label: 'Expense', value: 'expense' },
              ]}
            />
            <CFormLabel className="mt-2">Date</CFormLabel>
            <CDatePicker date="2023/7/03" label="Date" locale="en-US" />
            <CFormLabel className="mt-2">Category</CFormLabel>
            <CFormSelect
              aria-label="Category"
              options={[
                { label: 'Meal', value: 'Meal' },
                { label: 'Distraction', value: 'Distraction' },
                { label: 'Transport', value: 'Transport' },
                { label: 'Bills', value: 'Bills' },
                { label: 'Shopping', value: 'Shopping' },
                { label: 'Healthcare', value: 'Healthcare' },
                { label: 'Education', value: 'Education' },
                { label: 'Travel', value: 'Travel' },
                { label: 'Entertainment', value: 'Entertainment' },
                { label: 'Utilities', value: 'Utilities' },
                { label: 'Insurance', value: 'Insurance' },
                { label: 'Rent', value: 'Rent' },
                { label: 'Stocks ', value: 'Stocks' },
                { label: 'ETF ', value: 'ETF' },
                { label: 'Dividends ', value: 'Dividends ' },
                { label: 'Salary ', value: 'Salary ' },
                { label: 'Rental Income', value: 'Rental Income' },
              ]}
            />
            <CFormTextarea
              id="exampleFormControlTextarea1"
              label="Description"
              rows={2}
              className="mt-2"
            ></CFormTextarea>
            <CButton type="submit" color="primary" className="mt-3">
              Submit
            </CButton>
          </CForm>
        </CModalBody>
      </CModal>

      <CModal visible={showEditModal} onClose={() => setShowEditModal(false)}>
        <CModalHeader closeButton>
          <CModalTitle>Edit transactions</CModalTitle>
        </CModalHeader>
        <CModalBody>
          <CForm
            onSubmit={event => {
              event.preventDefault();
            }}
          >
            <CFormInput
              type="number"
              id="amount"
              label="Amount"
              defaultValue={editTransaction && editTransaction.amount ? editTransaction.amount : 0}
            />
            <CFormLabel className="mt-2">Type</CFormLabel>
            <CFormSelect
              aria-label="Type"
              value={editTransaction && editTransaction.type ? editTransaction.type : ''}
              options={[
                { label: 'Income', value: 'income' },
                { label: 'Expense', value: 'expense' },
              ]}
            />
            <CFormLabel className="mt-2">Date</CFormLabel>
            <CDatePicker
              /*@ts-ignore*/
              date="2023/7/03"
              label="Date"
              locale="en-US"
            />
            <CFormLabel className="mt-2">Category</CFormLabel>
            <CFormSelect
              aria-label="Category"
              value={editTransaction && editTransaction.category.name ? editTransaction.category.name : ''}
              options={[
                { label: 'Meal', value: 'Meal' },
                { label: 'Distraction', value: 'Distraction' },
                { label: 'Transport', value: 'Transport' },
                { label: 'Bills', value: 'Bills' },
                { label: 'Shopping', value: 'Shopping' },
                { label: 'Healthcare', value: 'Healthcare' },
                { label: 'Education', value: 'Education' },
                { label: 'Travel', value: 'Travel' },
                { label: 'Entertainment', value: 'Entertainment' },
                { label: 'Utilities', value: 'Utilities' },
                { label: 'Insurance', value: 'Insurance' },
                { label: 'Rent', value: 'Rent' },
                { label: 'Stocks', value: 'Stocks' },
                { label: 'ETF', value: 'ETF ' },
                { label: 'Dividends ', value: 'Dividends ' },
                { label: 'Salary', value: 'Salary ' },
                { label: 'Rental Income', value: 'Rental Income' },
              ]}
            />
            <CFormTextarea
              id="exampleFormControlTextarea1"
              label="Description"
              value={editTransaction && editTransaction.description ? editTransaction.description : ''}
              rows={2}
              className="mt-2"
            ></CFormTextarea>
            <CButton type="submit" color="primary" className="mt-3">
              Submit
            </CButton>
          </CForm>
        </CModalBody>
      </CModal>
      <CRow>
        <CCol sm={4}>
          <CWidgetStatsA
            className="mb-4"
            color="success"
            value={
              <div className="mb-4">
                <h1>Total Income</h1>
                <span className="mb-4">
                  +${totalIncome ? totalIncome : 0}{' '}
                  <span className="fs-6 fw-normal">
                    <CIcon icon={cilArrowTop} />
                  </span>
                </span>
                <div className="fs-6 fw-light text-light">
                  in{' '}
                  {transactions.reduce(function (ac, current) {
                    if (current.type === 'income') {
                      return ac + 1;
                    } else {
                      return ac;
                    }
                  }, 0)}{' '}
                  transactions
                </div>
              </div>
            }
            action={
              <CDropdown alignment="end">
                <CDropdownToggle color="transparent" caret={false} className="p-0">
                  <CIcon icon={cilOptions} className="text-high-emphasis-inverse" />
                </CDropdownToggle>
                <CDropdownMenu>
                  <CDropdownItem onClick={() => setShowAddModal(true)}>Add transaction</CDropdownItem>
                  <CDropdownItem>Edit</CDropdownItem>
                </CDropdownMenu>
              </CDropdown>
            }
          />
        </CCol>
        <CCol sm={4}>
          <CWidgetStatsA
            className="mb-4"
            color="danger"
            value={
              <div className="mb-4">
                <h1>Total Expenses</h1>
                <span className="mb-4">
                  -${totalExpenses}{' '}
                  <span className="fs-6 fw-normal">
                    <CIcon icon={cilArrowBottom} />
                  </span>
                </span>
                <div className="fs-6 fw-light text-light">
                  in{' '}
                  {transactions.reduce(function (ac, current) {
                    if (current.type === 'expense') {
                      return ac + 1;
                    } else {
                      return ac;
                    }
                  }, 0)}{' '}
                  transactions
                </div>
              </div>
            }
            action={
              <CDropdown alignment="end">
                <CDropdownToggle color="transparent" caret={false} className="p-0">
                  <CIcon icon={cilOptions} className="text-high-emphasis-inverse" />
                </CDropdownToggle>
                <CDropdownMenu>
                  <CDropdownItem>Add transactions</CDropdownItem>
                  <CDropdownItem>Edit</CDropdownItem>
                </CDropdownMenu>
              </CDropdown>
            }
          />
        </CCol>
        <CCol sm={4}>
          <CWidgetStatsA
            className="mb-4"
            color="info"
            value={
              <div className="mb-4">
                <h1>Remaining Balance</h1>
                <span className="mb-4">
                  {remainingBalance < 0 ? '-' : ''}${remainingBalance ? remainingBalance : 0}{' '}
                  <span className="fs-6 fw-normal"></span>
                </span>
                <div className="fs-6 fw-light text-light">28 days</div>
              </div>
            }
          />
        </CCol>
      </CRow>
      <CNav variant="pills" layout="fill" color="secondary" className="mb-3">
        <CNavItem>
          <CNavLink
            href="#"
            active={activetab === 0}
            onClick={e => {
              e.preventDefault();
              dispatch(dashboardActions.setPeriod({ startDate: '2024-07-01', endDate: '2024-07-31' }));
              setActiveTab(0);
            }}
          >
            July
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink
            href="#"
            active={activetab === 1}
            onClick={e => {
              e.preventDefault();
              dispatch(dashboardActions.setPeriod({ startDate: '2024-06-01', endDate: '2024-06-30' }));
              setActiveTab(1);
            }}
          >
            June
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink
            href="#"
            active={activetab === 2}
            onClick={e => {
              e.preventDefault();
              dispatch(dashboardActions.setPeriod({ startDate: '2024-05-01', endDate: '2024-05-31' }));
              setActiveTab(2);
            }}
          >
            May
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink
            href="#"
            active={activetab === 3}
            onClick={e => {
              e.preventDefault();
              dispatch(dashboardActions.setPeriod({ startDate: '2024-04-01', endDate: '2024-04-30' }));
              setActiveTab(3);
            }}
          >
            April
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink
            href="#"
            active={activetab === 4}
            onClick={e => {
              e.preventDefault();
              dispatch(dashboardActions.setPeriod({ startDate: '2024-03-01', endDate: '2024-03-31' }));
              setActiveTab(4);
            }}
          >
            March
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink
            href="#"
            active={activetab === 5}
            onClick={e => {
              e.preventDefault();
              dispatch(dashboardActions.setPeriod({ startDate: '2024-02-01', endDate: '2024-02-30' }));
              setActiveTab(5);
            }}
          >
            February
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink
            href="#"
            active={activetab === 6}
            onClick={e => {
              e.preventDefault();
              dispatch(dashboardActions.setPeriod({ startDate: '2024-01-01', endDate: '2024-01-31' }));
              setActiveTab(6);
            }}
          >
            January
          </CNavLink>
        </CNavItem>
      </CNav>
      <CRow className="mb-4 border">
        <CSmartTable
          activePage={2}
          cleaner
          clickableRows
          columns={columns}
          columnFilter
          columnSorter
          footer
          items={transactions}
          itemsPerPageSelect
          itemsPerPage={20}
          pagination
          onFilteredItemsChange={items => {
            console.log(items);
          }}
          onSelectedItemsChange={items => {
            console.log(items);
          }}
          scopedColumns={{
            type: item => (
              <td>
                <CBadge color={item.type === 'income' ? 'success' : 'danger'}>
                  <CIcon icon={item.type === 'income' ? cilArrowTop : cilArrowBottom}></CIcon>
                </CBadge>
              </td>
            ),
            amount: item => (
              <td>
                <CBadge color={item.type === 'income' ? 'success' : 'danger'}>
                  {item.type === 'income' ? '+' : '-'}${item.amount}
                </CBadge>
              </td>
            ),
            category: item => <td>{item.category.name.charAt(0).toUpperCase() + item.category.name.slice(1)}</td>,
            recursive: item => <td>{item.recursive ? 'Yes' : 'No'}</td>,
            date: item => {
              const date = new Date(Date.parse(item.date));
              return <td>{date.toDateString()}</td>;
            },
            show_details: item => {
              // @ts-ignore
              return (
                <td className="py-2">
                  <div className="d-flex justify-content-center align-content-center ">
                    <CButton className="d-flex justify-content-center align-items-center me-2" color="success">
                      <CIcon
                        icon={cilPencil}
                        className="text-light"
                        onClick={() => {
                          setShowEditModal(true);
                          setEditTransaction(item);
                        }}
                      ></CIcon>
                    </CButton>
                    <CButton
                      className="d-flex justify-content-center align-items-center"
                      color="danger"
                      onClick={event => {
                        onDelete(item.id);
                      }}
                    >
                      <CIcon icon={cilTrash} className="text-light"></CIcon>
                    </CButton>
                  </div>
                </td>
              );
            },
            details: item => {
              // @ts-ignore
              return (
                // @ts-ignore
                <CCollapse visible={details.includes(item.id)}>
                  <CCardBody className="p-3">
                    <h4>{item.username}</h4>
                    <p className="text-muted">User since: {item.registered}</p>
                    <CButton size="sm" color="info">
                      User Settings
                    </CButton>
                    <CButton size="sm" color="danger" className="ml-1">
                      Delete
                    </CButton>
                  </CCardBody>
                </CCollapse>
              );
            },
          }}
          sorterValue={{ column: 'status', state: 'asc' }}
          tableFilter
          tableProps={{
            className: 'add-this-class',
            responsive: true,
            striped: true,
            hover: true,
          }}
          tableBodyProps={{
            className: 'align-middle',
          }}
        />
      </CRow>
    </>
  );
}
