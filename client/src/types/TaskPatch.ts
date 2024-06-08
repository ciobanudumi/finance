import { Task } from './Task';

export interface TaskPatch extends Task {
  registrationDate: string | null;
  rfTasksetId: number | null;
  pop: string;
  row: number;
  frame: number;
  block: string;
  trayFiber: string;
  positionFiber: number;
  portingId: number;
  equipment: string;
  activePort: string;
  positionEquipment: string;
}
