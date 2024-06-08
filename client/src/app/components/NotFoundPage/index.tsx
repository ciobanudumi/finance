import * as React from 'react';
import { Helmet } from 'react-helmet-async';

import { CCol, CContainer, CRow } from '@coreui/react';
import classNames from 'classnames';

function NotFoundPage() {
  return (
    <>
      <Helmet>
        <title>404 Page Not Found</title>
        <meta name="description" content="Page not found" />
      </Helmet>
      <div className={classNames('c-app c-default-layout flex-row align-items-center')}>
        <CContainer>
          <CRow className="justify-content-center">
            <CCol md="6">
              <div className="clearfix">
                <h1 className="float-left display-3 mr-4">404</h1>
                <h4 className="pt-3">Oops! You{"'"}re lost.</h4>
                <p className="text-muted float-left">The page you are looking for was not found.</p>
              </div>
            </CCol>
          </CRow>
        </CContainer>
      </div>
    </>
  );
}
export default NotFoundPage;
