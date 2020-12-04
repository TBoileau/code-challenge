<?php


namespace App\UserInterface\Presenter\Security;


use App\UserInterface\ViewModel\Security\AskPasswordResetViewModel;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use TBoileau\CodeChallenge\Domain\Security\Presenter\AskPasswordResetPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Response\AskPasswordResetResponse;

class AskPasswordResetPresenter implements AskPasswordResetPresenterInterface
{
    /**
     * @var AskPasswordResetViewModel
     */
    private AskPasswordResetViewModel $viewModel;

    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * AskPasswordResetPresenter constructor.
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritDoc
     */
    public function present(AskPasswordResetResponse $response): void
    {
        $this->viewModel = new AskPasswordResetViewModel($response->isPasswordResetLinkSent(), $response->getLink());

        if ($response->isPasswordResetLinkSent()) {
            $this->flashBag->add(
                "success",
                "Un lien de réinitialisation de votre mot de passe a été envoyé à l'adresse email fournie !"
            );
        } else {
            $this->flashBag->add(
                "error",
                "Une erreur est subvenue. Veuillez réessayer plus tard svp !"
            );
        }
    }

    /**
     * @return AskPasswordResetViewModel
     */
    public function getViewModel(): AskPasswordResetViewModel
    {
        return $this->viewModel;
    }
}
