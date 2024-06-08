import React from 'react';
import { useTable, usePagination, useColumnOrder } from 'react-table';
import { CSpinner } from '@coreui/react';
import { isEmpty } from 'lodash';
import { useTranslation } from 'react-i18next';
import { customCellRenderer } from '../../../../utils/tableUtils';

export function SimpleTable({
  columns,
  data,
  onRowClick = null as any,
  trStyles = (rowValues = null as any) => null as any,
}) {
  const resultAvailable = data !== null && data !== false;
  const { t } = useTranslation();
  const { getTableProps, getTableBodyProps, prepareRow, page } = useTable(
    {
      columns,
      data,
      manualPagination: true,
    },
    usePagination,
    useColumnOrder,
  );

  if (!resultAvailable) {
    data = [];
  }

  return (
    <>
      <table className={`table table-responsive-sm table-striped table-bordered table-hover`} {...getTableProps()}>
        <tbody {...getTableBodyProps()}>
          {!resultAvailable ? (
            <tr>
              <td className="text-center">
                <CSpinner />
              </td>
            </tr>
          ) : isEmpty(data) ? (
            <tr>
              <td className="text-center">No available data</td>
            </tr>
          ) : (
            page.map(row => {
              prepareRow(row);

              return (
                <tr {...row.getRowProps()} style={{ ...trStyles(row.original) }}>
                  {row.cells.map(cell =>
                    cell.column.disableDefaultOnClick ? (
                      <td {...cell.getCellProps()} style={{ width: Math.floor(100 / columns.length) + '%' }}>
                        {cell.render(props => customCellRenderer(props))}
                      </td>
                    ) : (
                      <td
                        onClick={() =>
                          onRowClick && window.getSelection()?.toString().length === 0 ? onRowClick(row.original) : null
                        }
                        {...cell.getCellProps()}
                        style={{
                          cursor: onRowClick ? 'pointer' : 'auto',
                          width: Math.floor(100 / columns.length) + '%',
                        }}
                      >
                        {cell.render(props => customCellRenderer(props))}
                      </td>
                    ),
                  )}
                </tr>
              );
            })
          )}
        </tbody>
      </table>
    </>
  );
}

export default SimpleTable;
