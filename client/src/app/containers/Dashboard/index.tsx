import * as React from 'react';
import { useState } from 'react';
import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { reducer, sliceKey } from './slice';
import { dashboardSaga } from './saga';
import { useSelector } from 'react-redux';
import { selectUser } from '../App/selectors';
import { Helmet } from 'react-helmet-async';
import { useTranslation } from 'react-i18next';
import {
  CCol,
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
import { CBadge, CButton, CCardBody, CCollapse, CNav, CNavItem, CNavLink } from '@coreui/react';

export default function Dashboard() {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: dashboardSaga });
  const { t } = useTranslation();
  const user = useSelector(selectUser);

  const [details, setDetails] = useState([]);
  const columns = [
    {
      key: 'date',
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
  const usersData = [
    {
      id: 1,
      date: '2024-04-15',
      type: 'income',
      amount: 242.07,
      category: 'stocks',
    },
    {
      id: 2,
      date: '2023-08-14',
      type: 'income',
      amount: 274.53,
      category: 'freelance',
    },
    {
      id: 3,
      date: '2024-05-16',
      type: 'expense',
      amount: 397.12,
      category: 'entertainment',
    },
    {
      id: 4,
      date: '2024-04-24',
      type: 'income',
      amount: 944.02,
      category: 'freelance',
    },
    {
      id: 5,
      date: '2024-02-13',
      type: 'expense',
      amount: 454.58,
      category: 'meal',
    },
    {
      id: 6,
      date: '2023-08-16',
      type: 'expense',
      amount: 883.34,
      category: 'meal',
    },
    {
      id: 7,
      date: '2023-10-02',
      type: 'income',
      amount: 202.93,
      category: 'etf',
    },
    {
      id: 8,
      date: '2023-12-01',
      type: 'income',
      amount: 824.15,
      category: 'salary',
    },
    {
      id: 9,
      date: '2024-05-24',
      type: 'income',
      amount: 593.53,
      category: 'stocks',
    },
    {
      id: 10,
      date: '2024-01-20',
      type: 'expense',
      amount: 100.57,
      category: 'entertainment',
    },
    {
      id: 11,
      date: '2024-04-18',
      type: 'income',
      amount: 981.9,
      category: 'salary',
    },
    {
      id: 12,
      date: '2024-03-02',
      type: 'expense',
      amount: 280.41,
      category: 'rent',
    },
    {
      id: 13,
      date: '2023-09-15',
      type: 'expense',
      amount: 382.32,
      category: 'entertainment',
    },
    {
      id: 14,
      date: '2024-02-18',
      type: 'income',
      amount: 939.51,
      category: 'salary',
    },
    {
      id: 15,
      date: '2024-03-26',
      type: 'expense',
      amount: 579.26,
      category: 'distraction',
    },
    {
      id: 16,
      date: '2023-12-06',
      type: 'expense',
      amount: 375.62,
      category: 'transport',
    },
    {
      id: 17,
      date: '2024-01-11',
      type: 'expense',
      amount: 604.22,
      category: 'bills',
    },
    {
      id: 18,
      date: '2023-08-18',
      type: 'income',
      amount: 503.95,
      category: 'freelance',
    },
    {
      id: 19,
      date: '2023-06-22',
      type: 'expense',
      amount: 632.17,
      category: 'meal',
    },
    {
      id: 20,
      date: '2023-07-28',
      type: 'income',
      amount: 180.74,
      category: 'etf',
    },
    {
      id: 21,
      date: '2023-06-24',
      type: 'income',
      amount: 652.11,
      category: 'salary',
    },
    {
      id: 22,
      date: '2024-01-01',
      type: 'income',
      amount: 845.33,
      category: 'freelance',
    },
    {
      id: 23,
      date: '2023-10-21',
      type: 'expense',
      amount: 600.49,
      category: 'distraction',
    },
    {
      id: 24,
      date: '2023-08-15',
      type: 'expense',
      amount: 402.66,
      category: 'bills',
    },
    {
      id: 25,
      date: '2023-06-22',
      type: 'expense',
      amount: 336.34,
      category: 'meal',
    },
    {
      id: 26,
      date: '2024-01-10',
      type: 'income',
      amount: 90.99,
      category: 'freelance',
    },
    {
      id: 27,
      date: '2023-08-27',
      type: 'income',
      amount: 479.28,
      category: 'stocks',
    },
    {
      id: 28,
      date: '2024-03-29',
      type: 'income',
      amount: 728.65,
      category: 'salary',
    },
    {
      id: 29,
      date: '2023-07-02',
      type: 'expense',
      amount: 333.27,
      category: 'transport',
    },
    {
      id: 30,
      date: '2024-02-19',
      type: 'income',
      amount: 236.2,
      category: 'etf',
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

  return (
    <>
      <Helmet>
        <title>Dashboard</title>
      </Helmet>
      <CRow>
        <CCol sm={4}>
          <CWidgetStatsA
            className="mb-4"
            color="success"
            value={
              <div className="mb-4">
                <h1>Total Income</h1>
                <span className="mb-4">
                  +$9.000{' '}
                  <span className="fs-6 fw-normal">
                    (40.9% <CIcon icon={cilArrowTop} />)
                  </span>
                </span>
                <div className="fs-6 fw-light text-light">in 13 transactions</div>
              </div>
            }
            action={
              <CDropdown alignment="end">
                <CDropdownToggle color="transparent" caret={false} className="p-0">
                  <CIcon icon={cilOptions} className="text-high-emphasis-inverse" />
                </CDropdownToggle>
                <CDropdownMenu>
                  <CDropdownItem>Show transactions</CDropdownItem>
                  <CDropdownItem>Add Income</CDropdownItem>
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
                  -$5.670{' '}
                  <span className="fs-6 fw-normal">
                    (65.9% <CIcon icon={cilArrowBottom} />)
                  </span>
                </span>
                <div className="fs-6 fw-light text-light">in 67 transactions</div>
              </div>
            }
            action={
              <CDropdown alignment="end">
                <CDropdownToggle color="transparent" caret={false} className="p-0">
                  <CIcon icon={cilOptions} className="text-high-emphasis-inverse" />
                </CDropdownToggle>
                <CDropdownMenu>
                  <CDropdownItem>Show transactions</CDropdownItem>
                  <CDropdownItem>Add Income</CDropdownItem>
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
                  $4.330 <span className="fs-6 fw-normal">(38.9%)</span>
                </span>
                <div className="fs-6 fw-light text-light">7 days</div>
              </div>
            }
          />
        </CCol>
      </CRow>
      <CNav variant="pills" layout="fill" color="secondary" className="mb-3">
        <CNavItem>
          <CNavLink href="#" active>
            June
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">July</CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">August</CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#" disabled>
            September
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#" disabled>
            October
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#" disabled>
            November
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#" disabled>
            December
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
          items={usersData}
          itemsPerPageSelect
          itemsPerPage={5}
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
            category: item => <td>{item.category.charAt(0).toUpperCase() + item.category.slice(1)}</td>,
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
                      <CIcon icon={cilPencil} className="text-light"></CIcon>
                    </CButton>
                    <CButton className="d-flex justify-content-center align-items-center" color="danger">
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
