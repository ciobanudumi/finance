import { CButton, CButtonGroup, CCol, CFormLabel, CFormSwitch, CRow } from '@coreui/react';
import Select from 'react-select';
import React, { useState } from 'react';
import { useTranslation } from 'react-i18next';

function QuickFilters({ filters, resetAll, defaultFiltersOpen = false }) {
  const [displayFilters, setDisplayFilters] = useState(defaultFiltersOpen);
  const { t } = useTranslation();

  return (
    <>
      <CRow key="quick-filters-header">
        <CCol md={6}>
          <CButtonGroup>
            <CButton color="primary" onClick={() => setDisplayFilters(!displayFilters)}>
              Title
            </CButton>
            {displayFilters && (
              <CButton color="secondary" onClick={() => resetAll()}>
                Reset
              </CButton>
            )}
          </CButtonGroup>
        </CCol>
      </CRow>
      {displayFilters && (
        <CRow key="quick-filters-content" style={{ marginTop: 10 }}>
          {filters.map(filter => (
            <CCol key={filter.field} md={filter.fieldType === 'toggle' ? 2 : 4}>
              <CRow>
                <CFormLabel>{filter.label}</CFormLabel>
              </CRow>
              {filter.fieldType === 'toggle' ? (
                <CRow>
                  <CCol>
                    <CFormSwitch
                      name={filter.field}
                      color="success"
                      defaultChecked={filter.value}
                      onChange={filter.setter}
                    />
                  </CCol>
                </CRow>
              ) : (
                <CRow>
                  <CCol>
                    <Select
                      name={filter.field}
                      options={filter.options}
                      isSearchable={filter.searchable}
                      value={filter.value}
                      onChange={filter.setter}
                      onInputChange={filter.onInputChange}
                      isMulti={filter.isMulti}
                    />
                  </CCol>
                </CRow>
              )}
            </CCol>
          ))}
        </CRow>
      )}
    </>
  );
}

export default QuickFilters;
