import React, { memo, useEffect, useState } from 'react';
import { connect } from 'react-redux';
import { compose } from 'redux';
import { useReactTable, SortingState, getCoreRowModel, flexRender } from '@tanstack/react-table';
import { CRow, CCol, CDropdown, CDropdownToggle, CDropdownMenu, CDropdownItem, CSpinner } from '@coreui/react';
import CIcon from '@coreui/icons-react';
import { isEmpty } from 'lodash';
import { getTablePropsFromStorage, setTablePropsToStorage } from '../../../../utils/tableUtils';
import { useTranslation } from 'react-i18next';
import { DEFAULT_ITEMS_PER_PAGE_IN_TABLE, OFFSET_LIMIT } from '../../../../utils/constants';
import { Link, useNavigate } from 'react-router-dom';
import { CSmartPagination } from '@coreui/react-pro';
import { cilCaretBottom, cilCaretTop } from '@coreui/icons';

const defaultItemsPerPage = [10, 20, 30, 40, 50];

export function BackEndControlledTable({
  columns,
  data,
  fetchData = null as any,
  onRowClick = null as any,
  onRowRightClick = null as ((props: any) => string) | null,
  paginationIndex: controlledPageIndex,
  itemsPerPageControlled: itemsPerPage = defaultItemsPerPage,
  defaultItemsPerPageControlled = DEFAULT_ITEMS_PER_PAGE_IN_TABLE,
  tableName,
  trStyles = (rowValues = null as any) => null as any,
  totalItems,
  hiddenColumns = {},
  defaultSortBy = [{ id: 'id', desc: false }],
  disablePagination = false,
  resetPage = false,
  setResetPage = null as any,
}) {
  const [shouldFetchData, setShouldFetchData] = useState(true);
  const urlParams = new URLSearchParams(window.location.search.slice(1));
  const navigate = useNavigate();
  let initialSortBy = getTablePropsFromStorage(tableName).sorting;

  const [columnVisibility] = useState(hiddenColumns);

  const [sorting, setSorting] = useState<SortingState>(
    urlParams.has('order') &&
      urlParams.has('desc') &&
      columns.map(col => col.accessorKey.replace('.', '_')).includes(urlParams.get('order'))
      ? [{ id: urlParams.get('order') || 'id', desc: urlParams.get('desc') === 'true' }]
      : !initialSortBy || !columns.map(col => col.accessorKey.replace('.', '_')).includes(initialSortBy.id)
      ? getTablePropsFromStorage(tableName).sorting || defaultSortBy
      : defaultSortBy,
  );

  const [pageIndex, setPageIndex] = useState<number>(
    urlParams.has('page')
      ? Number(urlParams.get('page'))
      : getTablePropsFromStorage(tableName).pageIndex || controlledPageIndex,
  );

  const [pageSize, setPageSize] = useState<number>(
    disablePagination
      ? totalItems
      : urlParams.has('size')
      ? Number(urlParams.get('size'))
      : getTablePropsFromStorage(tableName).pageSize || defaultItemsPerPageControlled,
  );

  const table = useReactTable({
    data: data ?? [],
    columns,
    pageCount:
      totalItems > OFFSET_LIMIT + pageSize
        ? Math.floor((OFFSET_LIMIT + pageSize) / pageSize)
        : Math.ceil(totalItems / pageSize),
    state: {
      sorting,
      columnVisibility,
    },
    onSortingChange: setSorting,
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true,
  });

  const buildUrlParams = (pageUrl?: string | null) => {
    const newUrlParams = new URLSearchParams(window.location.search.slice(1));
    if (pageUrl) {
      newUrlParams.set('page', pageUrl);
    } else {
      newUrlParams.set('page', pageIndex <= 0 ? '1' : pageIndex.toString());
    }
    newUrlParams.set('size', pageSize.toString());
    newUrlParams.set('order', sorting[0]?.id !== undefined ? sorting[0]?.id.toString() : defaultSortBy[0].id);
    newUrlParams.set(
      'desc',
      sorting[0]?.desc !== undefined ? sorting[0]?.desc.toString() : defaultSortBy[0].desc.toString(),
    );
    return newUrlParams.toString();
  };

  const resultAvailable = data !== null && data !== false;

  const { t } = useTranslation();

  if (!resultAvailable) {
    data = [];
  }

  useEffect(() => {
    if (table.getPageCount() < pageIndex && table.getPageCount() >= 1) {
      setPageIndex(table.getPageCount());
    }
    // eslint-disable-next-line
  }, [pageSize]);

  useEffect(() => {
    if (fetchData) {
      setTablePropsToStorage(tableName, { pageSize, pageIndex, sorting });
      if (urlParams.has('page') && urlParams.has('order') && urlParams.has('desc') && urlParams.has('size')) {
        if (urlParams.toString() !== buildUrlParams()) {
          if (!sorting[0]) {
            navigate(`${window.location.pathname}?${buildUrlParams('1')}`);
            return;
          }
          if (urlParams.get('order') !== sorting[0].id) {
            navigate(`${window.location.pathname}?${buildUrlParams('1')}`);
          } else if (urlParams.get('desc') !== sorting[0].desc.toString()) {
            navigate(`${window.location.pathname}?${buildUrlParams('1')}`);
          } else {
            navigate(`${window.location.pathname}?${buildUrlParams()}`);
          }
        }
      }
    }
    // eslint-disable-next-line
  }, [pageIndex, pageSize, sorting]);

  useEffect(() => {
    if (fetchData) {
      if (!urlParams.has('page') || !urlParams.has('order') || !urlParams.has('desc') || !urlParams.has('size')) {
        if (urlParams.has('page')) {
          navigate(`${window.location.pathname}?${buildUrlParams(urlParams.get('page'))}`);
          table.setPageIndex(Number(urlParams.get('page')));
        } else {
          navigate(`${window.location.pathname}?${buildUrlParams()}`);
        }
      } else {
        const props = {
          pageIndex: Number(urlParams.get('page')),
          pageSize: Number(urlParams.get('size')),
          sortBy: [{ id: urlParams.get('order') ?? '', desc: urlParams.get('desc') === 'true' }],
        };
        fetchData({ ...props, shouldFetchData });
        setShouldFetchData(true);
      }
    }
    // eslint-disable-next-line
  }, [urlParams.toString()]);

  useEffect(() => {
    setPageIndex(1);
  }, [sorting]);

  useEffect(() => {
    if (resetPage) {
      setPageIndex(1);
      setResetPage(false);
    }
    // eslint-disable-next-line
  }, [resetPage]);

  return (
    <>
      <table className={`table table-responsive-sm table-striped table-bordered`}>
        <thead>
          {table.getHeaderGroups().map(headerGroup => (
            <tr {...headerGroup.headers} key={headerGroup.id}>
              {headerGroup.headers.map(header => (
                <th className="table-header-custom">
                  {header.isPlaceholder ? null : (
                    <div
                      {...{
                        className: header.column.getCanSort() ? 'cursor-pointer select-none' : '',
                        onClick: header.column.getToggleSortingHandler(),
                      }}
                    >
                      {flexRender(header.column.columnDef.header, header.getContext())}
                      {header.column.columnDef.enableSorting !== false && (
                        <span>
                          {{
                            asc: <CIcon icon={cilCaretTop} className="ms-1" />,
                            desc: <CIcon icon={cilCaretBottom} className="ms-1" />,
                          }[header.column.getIsSorted() as string] ?? null}
                        </span>
                      )}
                    </div>
                  )}
                </th>
              ))}
            </tr>
          ))}
        </thead>
        <tbody>
          {!resultAvailable ? (
            <tr>
              <td colSpan={columns.length} className="text-center">
                <CSpinner size="sm" />
              </td>
            </tr>
          ) : isEmpty(data) ? (
            <tr>
              <td colSpan={columns.length} className="text-center">
                No available data
              </td>
            </tr>
          ) : (
            <>
              {table.getRowModel().rows.map(row => {
                return (
                  <tr
                    style={{ cursor: onRowClick ? 'pointer' : 'auto', ...trStyles(row.original) }}
                    onClick={() =>
                      onRowClick && window.getSelection()?.toString().length === 0 ? onRowClick(row.original) : null
                    }
                  >
                    {row.getVisibleCells().map(cell => (
                      <td className="p-sm-0">
                        {onRowRightClick ? (
                          <Link to={onRowRightClick(row.original)} className="text-decoration-none text-reset">
                            <span className="w-100 h-100 d-block" style={{ padding: '0.75rem' }}>
                              {flexRender(cell.column.columnDef.cell, cell.getContext())}
                            </span>
                          </Link>
                        ) : (
                          <span
                            className="w-100 h-100 d-block text-decoration-none text-reset"
                            style={{ padding: '0.75rem' }}
                          >
                            {flexRender(cell.column.columnDef.cell, cell.getContext())}
                          </span>
                        )}
                      </td>
                    ))}
                  </tr>
                );
              })}
            </>
          )}
        </tbody>
      </table>

      {!disablePagination && (
        <CRow className="p-0 ps-3">
          <CCol xs="6" className="d-flex">
            <CDropdown className={table.getPageCount() === 0 ? 'd-none' : 'ml-3 mb-3'}>
              <CDropdownToggle caret color="primary">
                {pageSize}
              </CDropdownToggle>
              <CDropdownMenu>
                {itemsPerPage.map(size => (
                  <CDropdownItem key={size} onClick={() => setPageSize(size)}>
                    {size}
                  </CDropdownItem>
                ))}
              </CDropdownMenu>
            </CDropdown>
          </CCol>
          <CCol xs="6" className="d-flex justify-content-end">
            <CSmartPagination
              className={`cursor-pointer ${table.getPageCount() <= 1 ? 'd-none' : 'me-3'}`}
              size="sm"
              activePage={pageIndex}
              pages={table.getPageCount()}
              onActivePageChange={value => {
                setPageIndex(value);
              }}
            />
          </CCol>
        </CRow>
      )}
    </>
  );
}

BackEndControlledTable.propTypes = {};

function mapDispatchToProps(dispatch) {
  return {
    dispatch,
  };
}

const withConnect = connect(null, mapDispatchToProps);

export default compose(withConnect, memo)(BackEndControlledTable);
