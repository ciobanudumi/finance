import React from 'react';
import PropTypes from 'prop-types';
import { CCol, CRow } from '@coreui/react';

function LabelValue({ label, value, styleLabel, styleValue }) {
  return (
    <CRow>
      <CCol xs="6">
        {styleLabel ? (
          <p style={styleLabel}>
            <strong>{label}:</strong>
          </p>
        ) : (
          <p>
            <strong>{label}:</strong>
          </p>
        )}
      </CCol>
      <CCol xs="6">{styleValue ? <p style={styleValue}>{value}</p> : <p>{value}</p>}</CCol>
    </CRow>
  );
}

LabelValue.propTypes = {
  label: PropTypes.string.isRequired,
  styleLabel: PropTypes.any,
  styleValue: PropTypes.any,
};

export default LabelValue;
