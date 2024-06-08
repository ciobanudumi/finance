import { TaskPatch } from './TaskPatch';

export interface TaskPatchMigrate extends TaskPatch {
  patchcordLength: number;
  patchcordThickness: number;
}
