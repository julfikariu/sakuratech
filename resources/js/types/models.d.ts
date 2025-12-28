
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