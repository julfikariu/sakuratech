export interface Project {
    id: number;
    title: string;
    client_id: number;
    type: string;
    description: string;
    start_date: string;
    deadline: string;
    progress: number;
    status: 'Active' | 'Completed' | 'Pending';
    created_at: string;
}


export interface Client {
    id: number;
    user_id: number;
    company_name: string;
    phone: string;
    address: string;
    website: string;
    created_at: string;
}

export interface Contact {
    id: number;
    name: string;
    email: string;
    message: string;
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