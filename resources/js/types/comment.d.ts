export interface CommentUser {
  id: number;
  name: string;
}

export interface Comment {
  id: number | string;
  body: string;
  created_at: string;
  user: CommentUser;
  can_edit: boolean;
  can_delete: boolean;
  is_optimistic?: boolean;
}

export type CommentableType = 'task' | 'checklist_item' | 'project';
