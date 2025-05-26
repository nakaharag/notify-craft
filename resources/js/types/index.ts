
export interface PostIt {
    id: number;
    title: string;
    description: string;
    color: string;
    font_family: string;
    font_size: string;
    size: string;
    created_at: string;
    user: {
        id: number;
        name: string;
    };
}

export interface User {
    id: number;
    name: string;
    email: string;
}

export interface LoginCredentials {
    email: string;
    password: string;
}

export interface RegisterData {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}
