import React from 'react';
import { remove } from 'lodash';
import { localStorageGet, localStorageRemove, localStorageSet } from './localStorage';

export const customCellRenderer = ({ cell }) => <span>{cell.render('Cell')}</span>;

export function removeFromColumns(columns: Array<{ accessor: string }>, columnAccessor: string) {
  return remove(columns, column => column.accessor !== columnAccessor);
}

export const getTablePropsFromStorage = tableName => {
  let tablesProps;
  try {
    tablesProps = JSON.parse(localStorageGet('tablesProps') ?? '{}');
  } catch (e) {
    tablesProps = {};
  }
  if (!tablesProps[tableName]) {
    return false;
  }
  return tablesProps[tableName];
};

export const setTablePropsToStorage = (
  tableName,
  props: { pageSize: number; pageIndex: number; sorting: { id: string; desc: boolean }[] },
) => {
  let tablesProps;
  try {
    tablesProps = JSON.parse(localStorageGet('tablesProps') ?? '{}');
  } catch (e) {
    tablesProps = {};
  }
  tablesProps[tableName] = props;
  localStorageSet('tablesProps', JSON.stringify(tablesProps));
};

export function getStoredTableConfig(tableName: string) {
  return {
    order: JSON.parse(localStorageGet(`${tableName}:columnsOrder`) || 'null') as string[] | null,
    hidden: JSON.parse(localStorageGet(`${tableName}:hiddenColumns`) || 'null') as string[] | null,
  };
}

export function setStoredTableConfig(tableName: string, hiddenColumns: string[], columnsOrder: string[]) {
  localStorageSet(`${tableName}:columnsOrder`, JSON.stringify(columnsOrder));
  localStorageSet(`${tableName}:hiddenColumns`, JSON.stringify(hiddenColumns));
}

export function clearStoredTableConfig(tableName: string) {
  localStorageRemove(`${tableName}:columnsOrder`);
  localStorageRemove(`${tableName}:hiddenColumns`);
}
