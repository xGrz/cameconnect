import {Container} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";
import Typography from "@mui/material/Typography";

export default function UserSettings() {

    return (
        <AppProvider>
            <Container>
                <Typography variant={'h4'} component={'h1'}>Settings</Typography>
            </Container>
        </AppProvider>

    )
}
