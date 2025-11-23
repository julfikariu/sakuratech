
export interface Contact {
    id: number;
    name: string;
    email: string;
    message: string;
    created_at: string;
}

export interface PaginationLink {
    url: string | null
    label: string
    active: boolean
}