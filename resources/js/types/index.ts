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
