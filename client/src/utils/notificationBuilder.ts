import { Notification } from '../app/containers/App/types';

export default function notificationBuilder(
  type: 'default' | 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark',
  message,
  title: string | null = null,
  dismissCallback: Function | null = null,
  externalId: string | null = null,
): Notification {
  return {
    id: externalId ? externalId : Date.now().toString(),
    type,
    message,
    title,
    dismissCallback,
  };
}
