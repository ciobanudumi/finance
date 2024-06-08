import React, { memo, useEffect, useState } from 'react';
import { CToaster, CToast, CToastHeader, CToastBody, CRow, CCol, CButton, CToastClose } from '@coreui/react';
import { useDispatch } from 'react-redux';
import { appActions } from '../../containers/App/slice';
import { Notification as NotificationType } from '../../containers/App/types';
import { useTranslation } from 'react-i18next';

function Notification({ notifications }) {
  const [notificationsQueue, setNotificationsQueue] = useState<NotificationType[]>([]);
  const dispatch = useDispatch();
  const { t } = useTranslation();

  useEffect(() => {
    if (notifications?.length) {
      setNotificationsQueue([...notificationsQueue, ...notifications]);
      dispatch(appActions.removeNotifications());
    }
    // eslint-disable-next-line
  }, [notifications]);

  function onDismiss(notificationId) {
    const newNotificationsQueue = Array.from(notificationsQueue);
    const notifIndex = newNotificationsQueue.findIndex(elem => elem.id === notificationId);
    const removedNotif = newNotificationsQueue.splice(notifIndex, 1)[0];
    setNotificationsQueue(newNotificationsQueue);

    if (removedNotif.dismissCallback) {
      removedNotif.dismissCallback();
    }
  }

  return (
    <CRow>
      <CCol>
        {notificationsQueue && (
          <CToaster placement="top-end">
            {notificationsQueue.map(notification => (
              <CToast id={notification.id} color={notification.type} visible={true} delay={10000} animation={true}>
                <CToastHeader color={notification.type}>
                  {notification.title}
                  <CToastClose className="ms-auto" />
                </CToastHeader>
                <CToastBody>
                  {notification.message}
                  {notification.dismissCallback && (
                    <div className="mt-2 pt-2 border-top">
                      <CButton type="button" color="light" size="sm" onClick={() => onDismiss(notification.id)}>
                        Dismiss
                      </CButton>
                    </div>
                  )}
                </CToastBody>
              </CToast>
            ))}
          </CToaster>
        )}
      </CCol>
    </CRow>
  );
}

export default memo(Notification);
