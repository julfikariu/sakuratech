import type { PaginationLink } from '@/types/models';

export interface Invoice {
    id: number;
    inv_unique_id: string;
    client: string | null;
    project: string | null;
    amount: number;
    issue_date: string;
    due_date: string;
    status: string;
}

export interface PaginatedInvoices {
    data: Invoice[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
}
