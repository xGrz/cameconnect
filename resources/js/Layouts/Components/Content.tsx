import {PropsWithChildren} from "react";
import {red} from "@mui/material/colors";
import {Container} from "@mui/material";

export default function Content({children}: PropsWithChildren) {
    return (
        <Container sx={{ background: red[500]}}>
            {children}
        </Container>
    )
}
