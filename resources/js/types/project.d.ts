import type { PaginationLink } from '@/types/models';

interface Project {
    id: number;
    title: string;
    client_id: number;
    client_name: string | null;
    type: string;
    description: string;
    start_date: string;
    deadline: string;
    progress: number;
    status: 'Active' | 'Completed' | 'Pending';
    created_at: string;
}

interface PaginatedProjects {
    data: Project[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
}