
export interface Contact {
    id: number;
    name: string;
    email: string;
    subject?: string;
    message: string;
    created_at: string;
}

export interface TicketReply {
    id: number;
    message: string;
    user: { id: number; name: string };
    created_at: string;
}

export interface Ticket {
    id: number;
    title: string;
    description?: string | null;
    priority: 'Low' | 'Medium' | 'High';
    status: 'Open' | 'Pending' | 'Closed';
    assignee?: { id: number; name: string } | null;
    replies?: TicketReply[];
    created_at: string;
}

export interface Role {
    id: number,
    name: string,
    description: string,
}

export interface PaginationLink {
    url: string | null
    label: string
    active: boolean
}